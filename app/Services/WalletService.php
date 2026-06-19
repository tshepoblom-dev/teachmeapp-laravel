<?php

namespace App\Services;

use App\Enums\WalletTransactionType;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * WalletService — all wallet balance mutations go through here.
 *
 * Rules:
 *  - Never update `wallets.balance` directly from outside this service.
 *  - Every mutation is atomic: it creates a WalletTransaction AND updates the balance
 *    inside a single DB transaction with a row-level lock (lockForUpdate).
 *  - balance_before / balance_after are recorded for a full, immutable audit ledger.
 */
class WalletService
{
    // ── Core mutation ─────────────────────────────────────────────────────────

    /**
     * Credit the wallet (increase balance).
     *
     * @param  array{
     *   type: WalletTransactionType,
     *   amount: float,
     *   reference?: string,
     *   description?: string,
     *   metadata?: array,
     *   payment_transaction_id?: int,
     * } $context
     */
    public function credit(Wallet $wallet, float $amount, array $context = []): WalletTransaction
    {
        Log::info('WalletService: credit requested', [
            'wallet_id' => $wallet->id,
            'user_id'   => $wallet->user_id,
            'amount'    => $amount,
            'type'      => ($context['type'] ?? null)?->value ?? $context['type'] ?? null,
            'reference' => $context['reference'] ?? null,
        ]);

        return $this->mutate($wallet, $amount, 'credit', $context);
    }

    /**
     * Debit the wallet (decrease balance).
     *
     * @throws RuntimeException if insufficient funds.
     */
    public function debit(Wallet $wallet, float $amount, array $context = []): WalletTransaction
    {
        Log::info('WalletService: debit requested', [
            'wallet_id' => $wallet->id,
            'user_id'   => $wallet->user_id,
            'amount'    => $amount,
            'type'      => ($context['type'] ?? null)?->value ?? $context['type'] ?? null,
            'reference' => $context['reference'] ?? null,
        ]);

        return $this->mutate($wallet, $amount, 'debit', $context);
    }

    // ── Internal ──────────────────────────────────────────────────────────────

    private function mutate(Wallet $wallet, float $amount, string $direction, array $context): WalletTransaction
    {
        if ($amount <= 0) {
            Log::warning('WalletService: invalid mutation amount', [
                'wallet_id' => $wallet->id,
                'amount'    => $amount,
                'direction' => $direction,
            ]);
            throw new RuntimeException('Wallet mutation amount must be positive.');
        }

        return DB::transaction(function () use ($wallet, $amount, $direction, $context) {
            // Row-level lock to prevent concurrent mutations
            $wallet = Wallet::lockForUpdate()->findOrFail($wallet->id);

            if ($direction === 'debit' && $wallet->balance < $amount) {
                Log::warning('WalletService: insufficient funds', [
                    'wallet_id' => $wallet->id,
                    'user_id'   => $wallet->user_id,
                    'balance'   => $wallet->balance,
                    'requested' => $amount,
                ]);
                throw new RuntimeException(
                    "Insufficient wallet balance. Available: {$wallet->balance}, Requested: {$amount}"
                );
            }

            $balanceBefore = $wallet->balance;
            $balanceAfter  = $direction === 'credit'
                ? bcadd((string) $balanceBefore, (string) $amount, 2)
                : bcsub((string) $balanceBefore, (string) $amount, 2);

            $wallet->balance = $balanceAfter;
            $wallet->save();

            $tx = WalletTransaction::create([
                'wallet_id'              => $wallet->id,
                'type'                   => $context['type'] ?? ($direction === 'credit' ? WalletTransactionType::Deposit : WalletTransactionType::Withdrawal),
                'amount'                 => $amount,
                'direction'              => $direction,
                'balance_before'         => $balanceBefore,
                'balance_after'          => $balanceAfter,
                'reference'              => $context['reference']  ?? null,
                'description'            => $context['description'] ?? null,
                'metadata'               => $context['metadata']   ?? null,
                'payment_transaction_id' => $context['payment_transaction_id'] ?? null,
            ]);

            Log::info('WalletService: mutation committed', [
                'wallet_transaction_id' => $tx->id,
                'wallet_id'             => $wallet->id,
                'user_id'               => $wallet->user_id,
                'direction'             => $direction,
                'amount'                => $amount,
                'balance_before'        => $balanceBefore,
                'balance_after'         => $balanceAfter,
            ]);

            return $tx;
        });
    }

    // ── Balance helpers ───────────────────────────────────────────────────────

    /** Returns the current spendable balance (excluding escrow). */
    public function availableBalance(Wallet $wallet): string
    {
        return (string) (Wallet::find($wallet->id)?->balance ?? '0.00');
    }

    /** Check whether the wallet can cover a given amount. */
    public function hasSufficientFunds(Wallet $wallet, float $amount): bool
    {
        return bccomp(
            $this->availableBalance($wallet),
            (string) $amount,
            2
        ) >= 0;
    }

    /**
     * Record a platform fee ledger entry.
     * This does NOT modify any wallet balance — it is a pure audit record
     * representing revenue collected by the platform (commission, penalties, etc.)
     */
    public function recordPlatformFee(float $amount, int $bookingId, string $reference): void
    {
        \App\Models\WalletTransaction::create([
            'wallet_id'      => null, // Platform — no user wallet
            'type'           => \App\Enums\WalletTransactionType::PlatformFee,
            'amount'         => $amount,
            'direction'      => 'credit',
            'balance_before' => 0,
            'balance_after'  => 0,
            'reference'      => $reference,
            'description'    => "Platform commission for booking #{$bookingId}",
            'metadata'       => json_encode(['booking_id' => $bookingId]),
        ]);

        Log::info('WalletService: platform fee recorded', [
            'booking_id' => $bookingId,
            'amount'     => $amount,
            'reference'  => $reference,
        ]);
    }
}
