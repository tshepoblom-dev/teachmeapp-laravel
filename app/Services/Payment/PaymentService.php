<?php

namespace App\Services\Payment;

use App\Enums\PaymentStatus;
use App\Enums\WalletTransactionType;
use App\Models\Booking;
use App\Models\PayfastTransaction;
use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * PaymentService — high-level orchestrator for all payment flows.
 *
 * Responsibilities:
 *   - Resolve the correct gateway via GatewayManager.
 *   - Create and update PaymentTransaction records.
 *   - Delegate wallet credit/debit to WalletService.
 *   - Persist gateway-specific records (PayfastTransaction, etc.).
 *   - Provide a single handleWebhookResult() entry point for webhook controllers.
 */
class PaymentService
{
    public function __construct(
        private readonly GatewayManager $gatewayManager,
        private readonly WalletService  $walletService,
    ) {}

    // ── Deposit (wallet top-up) ───────────────────────────────────────────────

    /**
     * Initiate a wallet deposit via the specified gateway.
     *
     * @return array{
     *   transaction: PaymentTransaction,
     *   gateway_response: array,
     * }
     */
    public function initiateDeposit(User $user, float $amount, string $gatewayCode): array
    {
        $gateway = $this->gatewayManager->driver($gatewayCode);
        $wallet  = $user->wallet ?? throw new RuntimeException('User has no wallet.');

        $reference = 'DEP-' . strtoupper(Str::random(12));

        /** @var PaymentTransaction $transaction */
        $transaction = DB::transaction(function () use ($user, $wallet, $amount, $gatewayCode, $reference) {
            $method = PaymentMethod::where('code', $gatewayCode)->firstOrFail();

            return PaymentTransaction::create([
                'user_id'           => $user->id,
                'wallet_id'         => $wallet->id,
                'payment_method_id' => $method->id,
                'amount'            => $amount,
                'currency'          => $wallet->currency,
                'status'            => PaymentStatus::Pending,
                'metadata'          => ['type' => 'deposit', 'reference' => $reference],
            ]);
        });

        $gatewayResponse = $gateway->initializePayment([
            'amount'      => $amount,
            'currency'    => $wallet->currency,
            'description' => 'Wallet top-up',
            'return_url'  => route('payment.callback', ['gateway' => $gatewayCode]) . '?ref=' . $transaction->id,
            'cancel_url' => route('student.wallet.index', [], true) . '?cancelled=1',
            'notify_url'  => route('payment.webhook', ['gateway' => $gatewayCode]),
            'user_email'  => $user->email,
            'user_name'   => $user->name,
            'reference'   => $reference,
            'metadata'    => ['transaction_id' => $transaction->id],
        ]);

        // For gateway-specific record creation
        $this->createGatewayRecord($gatewayCode, $transaction, $wallet, $gatewayResponse);

        Log::info('PaymentService: deposit initiated', [
            'user_id'        => $user->id,
            'transaction_id' => $transaction->id,
            'amount'         => $amount,
            'gateway'        => $gatewayCode,
            'reference'      => $reference,
        ]);

        // Wallet balance gateway settles immediately
        if (! empty($gatewayResponse['direct_success'])) {
            $this->settleDeposit($transaction, $wallet, $amount);
        }

        return ['transaction' => $transaction->fresh(), 'gateway_response' => $gatewayResponse];
    }

    // ── Booking payment ───────────────────────────────────────────────────────

    /**
     * Pay for a booking using a specified gateway.
     * For wallet_balance: immediately debits and marks complete.
     * For redirect gateways: returns redirect data; booking transitions on webhook.
     *
     * @return array{
     *   transaction: PaymentTransaction,
     *   gateway_response: array,
     * }
     */
    public function initiateBookingPayment(User $student, Booking $booking, string $gatewayCode): array
    {
        if ($booking->student_id !== $student->id) {
            throw new RuntimeException('Booking does not belong to this student.');
        }

        if ($booking->status->value !== 'pending') {
            throw new RuntimeException('Only pending bookings can be paid for.');
        }

        $gateway = $this->gatewayManager->driver($gatewayCode);
        $wallet  = $student->wallet ?? throw new RuntimeException('Student has no wallet.');
        $amount  = $booking->total_amount;

        // Pre-flight balance check for wallet payments
        if ($gatewayCode === 'wallet_balance' && ! $this->walletService->hasSufficientFunds($wallet, $amount)) {
            throw new RuntimeException("Insufficient wallet balance. Required: {$amount}, Available: {$wallet->balance}");
        }

        $reference = 'BKG-' . $booking->id . '-' . strtoupper(Str::random(8));

        /** @var PaymentTransaction $transaction */
        $transaction = DB::transaction(function () use ($student, $wallet, $booking, $gatewayCode, $reference, $amount) {
            $method = PaymentMethod::where('code', $gatewayCode)->firstOrFail();

            return PaymentTransaction::create([
                'user_id'           => $student->id,
                'wallet_id'         => $wallet->id,
                'booking_id'        => $booking->id,
                'payment_method_id' => $method->id,
                'amount'            => $amount,
                'currency'          => $wallet->currency,
                'status'            => PaymentStatus::Pending,
                'metadata'          => ['type' => 'booking_payment', 'reference' => $reference],
            ]);
        });

        $gatewayResponse = $gateway->initializePayment([
            'amount'      => $amount,
            'currency'    => $wallet->currency,
            'description' => "Booking #{$booking->id}: {$booking->subject}",
            'return_url'  => route('payment.callback', ['gateway' => $gatewayCode]) . '?ref=' . $transaction->id,
            'cancel_url' => route('student.bookings.show', $booking, true) . '?cancelled=1',
            'notify_url'  => route('payment.webhook', ['gateway' => $gatewayCode]),
            'user_email'  => $student->email,
            'user_name'   => $student->name,
            'reference'   => $reference,
        ]);

        $this->createGatewayRecord($gatewayCode, $transaction, $wallet, $gatewayResponse);

        Log::info('PaymentService: booking payment initiated', [
            'student_id'     => $student->id,
            'booking_id'     => $booking->id,
            'transaction_id' => $transaction->id,
            'amount'         => $amount,
            'gateway'        => $gatewayCode,
            'reference'      => $reference,
        ]);

        // Wallet payments settle synchronously
        if (! empty($gatewayResponse['direct_success'])) {
            $this->settleBookingPayment($transaction, $wallet, $booking, $amount);
        }

        return ['transaction' => $transaction->fresh(), 'gateway_response' => $gatewayResponse];
    }

    // ── Webhook processing ────────────────────────────────────────────────────

    /**
     * Process an already-verified webhook result from a gateway.
     * Called by WebhookController after gateway->handleWebhook() returns.
     */
    public function handleWebhookResult(string $gatewayCode, array $result): void
    {
        if (empty($result['verified']) || empty($result['reference'])) {
            Log::warning("handleWebhookResult: unverified or missing reference [{$gatewayCode}]", $result);
            return;
        }

        DB::transaction(function () use ($gatewayCode, $result) {
            // Locate the transaction by its reference stored in metadata
            $transaction = PaymentTransaction::where('metadata->reference', $result['reference'])
                ->orWhere('gateway_transaction_id', $result['reference'])
                ->lockForUpdate()
                ->first();

            if (! $transaction) {
                Log::warning("handleWebhookResult: no transaction found for reference [{$result['reference']}]");
                return;
            }

            // Idempotency: skip already-completed/failed
            if (in_array($transaction->status->value, ['completed', 'failed', 'refunded', 'cancelled'])) {
                return;
            }

            $newStatus = PaymentStatus::from($result['status'] === 'completed' ? 'completed' : ($result['status'] === 'failed' ? 'failed' : 'cancelled'));

            $transaction->update([
                'status'                 => $newStatus,
                'gateway_transaction_id' => $result['pf_payment_id'] ?? $result['gateway_reference'] ?? $transaction->gateway_transaction_id,
                'gateway_status'         => $result['status'],
                'completed_at'           => $newStatus === PaymentStatus::Completed ? now() : null,
            ]);

            // Update gateway-specific record
            if ($gatewayCode === 'payfast') {
                PayfastTransaction::where('payment_transaction_id', $transaction->id)->update([
                    'pf_payment_id'   => $result['pf_payment_id']   ?? null,
                    'amount_gross'    => $result['amount']           ?? 0,
                    'amount_fee'      => $result['amount_fee']       ?? 0,
                    'amount_net'      => $result['amount_net']       ?? 0,
                    'payment_status'  => $result['status'] === 'completed' ? 'complete' : 'failed',
                    'itn_verified'    => true,
                    'itn_payload'     => $result['raw'] ?? null,
                ]);
            }

            // Credit wallet on successful deposit
            if ($newStatus === PaymentStatus::Completed && $transaction->wallet_id) {
                $wallet   = Wallet::find($transaction->wallet_id);
                $metadata = $transaction->metadata ?? [];
                $type     = $metadata['type'] ?? '';

                if ($type === 'deposit') {
                    $this->settleDeposit($transaction, $wallet, (float) $transaction->amount);
                } elseif ($type === 'booking_payment' && $transaction->booking_id) {
                    $booking = Booking::find($transaction->booking_id);
                    if ($booking) {
                        $this->settleBookingPayment($transaction, $wallet, $booking, (float) $transaction->amount);
                    }
                }
            }
        });
    }

    // ── Settlement helpers ────────────────────────────────────────────────────

    private function settleDeposit(PaymentTransaction $transaction, Wallet $wallet, float $amount): void
    {
        $this->walletService->credit($wallet, $amount, [
            'type'                   => WalletTransactionType::Deposit,
            'reference'              => $transaction->gateway_transaction_id ?? $transaction->id,
            'description'            => 'Wallet top-up',
            'payment_transaction_id' => $transaction->id,
        ]);

        $transaction->update([
            'status'       => PaymentStatus::Completed,
            'completed_at' => now(),
        ]);

        Log::info('PaymentService: deposit settled', [
            'transaction_id' => $transaction->id,
            'wallet_id'      => $wallet->id,
            'amount'         => $amount,
        ]);
    }

    private function settleBookingPayment(PaymentTransaction $transaction, Wallet $wallet, Booking $booking, float $amount): void
    {
        // Debit the wallet
        $this->walletService->debit($wallet, $amount, [
            'type'                   => WalletTransactionType::EscrowHold,
            'reference'              => "BKG-{$booking->id}",
            'description'            => "Payment for booking #{$booking->id}",
            'payment_transaction_id' => $transaction->id,
        ]);

        $transaction->update([
            'status'       => PaymentStatus::Completed,
            'completed_at' => now(),
        ]);

        // Update the booking's payment_method_id
        $booking->update(['payment_method_id' => $transaction->payment_method_id]);

        Log::info('PaymentService: booking payment settled', [
            'transaction_id' => $transaction->id,
            'booking_id'     => $booking->id,
            'wallet_id'      => $wallet->id,
            'amount'         => $amount,
        ]);
    }

    // ── Gateway record creation ───────────────────────────────────────────────

    private function createGatewayRecord(string $code, PaymentTransaction $tx, Wallet $wallet, array $resp): void
    {
        if ($code === 'payfast') {
            PayfastTransaction::create([
                'payment_transaction_id' => $tx->id,
                'wallet_id'              => $wallet->id,
                'm_payment_id'           => $resp['transaction_reference'] ?? $tx->id,
                'amount_gross'           => $tx->amount,
                'amount_fee'             => 0,
                'amount_net'             => $tx->amount,
                'item_name'              => substr($tx->metadata['type'] ?? 'payment', 0, 100),
                'payment_status'         => 'initiated',
                'itn_verified'           => false,
            ]);
        }
        // Ozow and wallet_balance have no separate DB records beyond PaymentTransaction
    }

    // ── Refund ────────────────────────────────────────────────────────────────

    /**
     * Initiate a refund through the original gateway.
     */
    public function refund(PaymentTransaction $transaction, float $amount, string $reason = ''): array
    {
        $method  = $transaction->paymentMethod;
        $gateway = $this->gatewayManager->driverUnchecked($method->code);
        $result  = $gateway->refund($transaction, $amount, $reason);

        if ($result['success']) {
            $transaction->update([
                'status'        => PaymentStatus::Refunded,
                'refunded_at'   => now(),
                'refund_amount' => $amount,
            ]);

            if ($method->code === 'wallet_balance' && $transaction->wallet_id) {
                $wallet = Wallet::findOrFail($transaction->wallet_id);
                $this->walletService->credit($wallet, $amount, [
                    'type'                   => WalletTransactionType::Refund,
                    'description'            => "Refund for transaction #{$transaction->id}",
                    'payment_transaction_id' => $transaction->id,
                ]);
            }

            Log::info('PaymentService: refund processed', [
                'transaction_id' => $transaction->id,
                'amount'         => $amount,
                'gateway'        => $method->code,
                'reason'         => $reason,
            ]);
        } else {
            Log::warning('PaymentService: refund failed', [
                'transaction_id' => $transaction->id,
                'amount'         => $amount,
                'gateway'        => $method->code,
                'result'         => $result,
            ]);
        }

        return $result;
    }
}
