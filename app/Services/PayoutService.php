<?php

namespace App\Services;

use App\Enums\WalletTransactionType;
use App\Events\PayoutCompleted;
use App\Events\PayoutFailed;
use App\Models\AuditLog;
use App\Models\PayoutAccount;
use App\Models\PayoutTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * PayoutService — all tutor withdrawal logic lives here.
 *
 * Responsibilities:
 *  - Payout account CRUD + verification workflow
 *  - Withdrawal request: validates balance, debits wallet atomically, creates PayoutTransaction
 *  - Admin manual-transfer workflow: pending → processing → completed/failed
 *  - Cancellation (tutor or admin) with wallet refund
 */
class PayoutService
{
    public function __construct(private readonly WalletService $walletService) {}

    // ─── Payout accounts ──────────────────────────────────────────────────────

    /**
     * Create a new payout account for a tutor.
     *
     * @param  array{
     *   account_type: string,
     *   account_holder_name: string,
     *   account_number: string,
     *   branch_code?: string,
     *   bank_name?: string,
     *   is_default?: bool,
     * } $data
     */
    public function createAccount(User $tutor, array $data): PayoutAccount
    {
        return DB::transaction(function () use ($tutor, $data) {
            // One default per user
            if ($data['is_default'] ?? false) {
                PayoutAccount::where('user_id', $tutor->id)
                    ->update(['is_default' => false]);
            }

            $account = PayoutAccount::create([
                'user_id'                  => $tutor->id,
                'account_type'             => $data['account_type'],
                'account_holder_name'      => $data['account_holder_name'],
                'account_number_encrypted' => encrypt($data['account_number'] ?? ''),
                'branch_code'              => $data['branch_code'] ?? null,
                'bank_name'                => $data['bank_name'] ?? null,
                'is_default'               => $data['is_default'] ?? false,
                'is_verified'              => false,
            ]);

            AuditLog::create([
                'user_id'     => $tutor->id,
                'action'      => 'payout_account_created',
                'target_type' => 'payout_account',
                'target_id'   => $account->id,
                'new_values'  => [
                    'bank_name'    => $account->bank_name,
                    'account_type' => $account->account_type,
                ],
            ]);

            Log::info('Payout account created', [
                'user_id'    => $tutor->id,
                'account_id' => $account->id,
            ]);

            return $account;
        });
    }

    /**
     * Set an existing account as the tutor's default.
     */
    public function setDefaultAccount(User $tutor, PayoutAccount $account): void
    {
        if ($account->user_id !== $tutor->id) {
            throw new RuntimeException('Account does not belong to this tutor.');
        }

        DB::transaction(function () use ($tutor, $account) {
            PayoutAccount::where('user_id', $tutor->id)->update(['is_default' => false]);
            $account->update(['is_default' => true]);
        });
    }

    /**
     * Delete a payout account — only allowed if no pending/processing payouts reference it.
     */
    public function deleteAccount(User $tutor, PayoutAccount $account): void
    {
        if ($account->user_id !== $tutor->id) {
            throw new RuntimeException('Account does not belong to this tutor.');
        }

        $blockedStatuses = ['pending', 'processing'];
        $hasActive = PayoutTransaction::where('payout_account_id', $account->id)
            ->whereIn('status', $blockedStatuses)
            ->exists();

        if ($hasActive) {
            throw new RuntimeException('Cannot delete an account with pending or processing payouts.');
        }

        $account->delete();
    }

    /**
     * Admin: mark a payout account as verified.
     */
    public function verifyAccount(PayoutAccount $account, User $admin): PayoutAccount
    {
        $account->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        AuditLog::create([
            'user_id'     => $admin->id,
            'action'      => 'payout_account_verified',
            'target_type' => 'payout_account',
            'target_id'   => $account->id,
            'new_values'  => ['verified_at' => now()->toIso8601String()],
        ]);

        return $account->fresh();
    }

    /**
     * Admin: revoke verification on a payout account.
     */
    public function unverifyAccount(PayoutAccount $account, User $admin): PayoutAccount
    {
        $account->update(['is_verified' => false, 'verified_at' => null]);

        AuditLog::create([
            'user_id'     => $admin->id,
            'action'      => 'payout_account_unverified',
            'target_type' => 'payout_account',
            'target_id'   => $account->id,
        ]);

        return $account->fresh();
    }

    // ─── Withdrawal requests ──────────────────────────────────────────────────

    /**
     * Tutor requests a withdrawal.
     *
     * - Validates minimum payout amount.
     * - Verifies account belongs to tutor and is verified.
     * - Atomically debits the wallet and creates a PayoutTransaction in 'pending' state.
     *
     * @param  array{amount: float, payout_account_id: int}  $data
     */
    public function requestWithdrawal(User $tutor, array $data): PayoutTransaction
    {
        $wallet = $this->walletService->getOrCreateWallet($tutor);

        $account = PayoutAccount::where('id', $data['payout_account_id'])
            ->where('user_id', $tutor->id)
            ->firstOrFail();

        if (! $account->is_verified) {
            throw new RuntimeException('Payout account must be verified before withdrawals can be requested.');
        }

        $amount = (float) $data['amount'];

        if ($amount < 50) {
            throw new RuntimeException('Minimum payout amount is R50.00.');
        }

        return DB::transaction(function () use ($tutor, $wallet, $account, $amount) {
            // Debit wallet immediately — funds are reserved on request
            $this->walletService->debit($wallet, $amount, [
                'type'        => WalletTransactionType::Payout,
                'reference'   => $ref = 'PAY-' . strtoupper(Str::random(10)),
                'description' => "Withdrawal request to {$account->bank_name}",
            ]);

            $payout = PayoutTransaction::create([
                'user_id'           => $tutor->id,
                'payout_account_id' => $account->id,
                'amount'            => $amount,
                'status'            => 'pending',
                'reference'         => $ref,
            ]);

            AuditLog::create([
                'user_id'     => $tutor->id,
                'action'      => 'payout_requested',
                'target_type' => 'payout_transaction',
                'target_id'   => $payout->id,
                'new_values'  => ['amount' => $amount, 'reference' => $ref],
            ]);

            Log::info('Payout requested', [
                'user_id'    => $tutor->id,
                'payout_id'  => $payout->id,
                'amount'     => $amount,
                'reference'  => $ref,
            ]);

            return $payout;
        });
    }

    /**
     * Tutor cancels their own pending payout — refunds wallet.
     */
    public function cancelWithdrawal(User $tutor, PayoutTransaction $payout): PayoutTransaction
    {
        if ($payout->user_id !== $tutor->id) {
            throw new RuntimeException('Payout does not belong to this tutor.');
        }

        if ($payout->status !== 'pending') {
            throw new RuntimeException('Only pending payouts can be cancelled.');
        }

        return DB::transaction(function () use ($tutor, $payout) {
            // Refund the wallet
            $tutor->loadMissing('wallet');
            $this->walletService->credit($tutor->wallet, (float) $payout->amount, [
                'type'        => WalletTransactionType::Refund,
                'reference'   => $payout->reference,
                'description' => "Payout cancelled — refund of {$payout->reference}",
            ]);

            $payout->update(['status' => 'cancelled']);

            AuditLog::create([
                'user_id'     => $tutor->id,
                'action'      => 'payout_cancelled',
                'target_type' => 'payout_transaction',
                'target_id'   => $payout->id,
                'old_values'  => ['status' => 'pending'],
                'new_values'  => ['status' => 'cancelled'],
            ]);

            return $payout->fresh();
        });
    }

    // ─── Admin manual-transfer workflow ───────────────────────────────────────

    /**
     * Admin marks a payout as 'processing' (bank transfer initiated).
     */
    public function markProcessing(PayoutTransaction $payout, User $admin): PayoutTransaction
    {
        if ($payout->status !== 'pending') {
            throw new RuntimeException('Only pending payouts can be moved to processing.');
        }

        $payout->update(['status' => 'processing']);

        AuditLog::create([
            'user_id'     => $admin->id,
            'action'      => 'payout_marked_processing',
            'target_type' => 'payout_transaction',
            'target_id'   => $payout->id,
        ]);

        return $payout->fresh();
    }

    /**
     * Admin marks a payout as completed.
     *
     * @param  string|null  $externalPayoutId  Bank/gateway reference number
     */
    public function markCompleted(
        PayoutTransaction $payout,
        User $admin,
        ?string $externalPayoutId = null
    ): PayoutTransaction {
        if (! in_array($payout->status, ['pending', 'processing'])) {
            throw new RuntimeException('Only pending or processing payouts can be completed.');
        }

        $payout->update([
            'status'             => 'completed',
            'processed_at'       => now(),
            'external_payout_id' => $externalPayoutId,
        ]);

        AuditLog::create([
            'user_id'     => $admin->id,
            'action'      => 'payout_completed',
            'target_type' => 'payout_transaction',
            'target_id'   => $payout->id,
            'new_values'  => [
                'external_payout_id' => $externalPayoutId,
                'processed_at'       => now()->toIso8601String(),
            ],
        ]);

        Log::info('Payout completed by admin', [
            'payout_id'  => $payout->id,
            'admin_id'   => $admin->id,
            'reference'  => $payout->reference,
        ]);

        PayoutCompleted::dispatch($payout->fresh());

        return $payout->fresh();
    }

    /**
     * Admin marks a payout as failed and refunds the tutor's wallet.
     */
    public function markFailed(
        PayoutTransaction $payout,
        User $admin,
        string $failureReason
    ): PayoutTransaction {
        if (! in_array($payout->status, ['pending', 'processing'])) {
            throw new RuntimeException('Only pending or processing payouts can be marked as failed.');
        }

        return DB::transaction(function () use ($payout, $admin, $failureReason) {
            $tutor  = $payout->user()->first();
            $wallet = $this->walletService->getOrCreateWallet($tutor);

            // Refund the tutor's wallet
            $this->walletService->credit($wallet, (float) $payout->amount, [
                'type'        => WalletTransactionType::Refund,
                'reference'   => $payout->reference,
                'description' => "Payout failed — refunded {$payout->reference}",
            ]);

            $payout->update([
                'status'         => 'failed',
                'failure_reason' => $failureReason,
            ]);

            AuditLog::create([
                'user_id'     => $admin->id,
                'action'      => 'payout_failed',
                'target_type' => 'payout_transaction',
                'target_id'   => $payout->id,
                'new_values'  => ['failure_reason' => $failureReason],
            ]);

            Log::warning('Payout failed — wallet refunded', [
                'payout_id' => $payout->id,
                'tutor_id'  => $tutor->id,
                'amount'    => $payout->amount,
            ]);

            PayoutFailed::dispatch($payout->fresh());

            return $payout->fresh();
        });
    }
}