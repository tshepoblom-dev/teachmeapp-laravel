<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentGatewayInterface;
use App\Models\PaymentTransaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Wallet Balance Gateway — internal payment method.
 *
 * No external HTTP calls. Payment is settled synchronously by debiting
 * the user's platform wallet. This is the only gateway that returns
 * `direct_success: true` from initializePayment().
 *
 * Balance availability must be checked by PaymentService before calling
 * initializePayment(), since this gateway has no async confirmation step.
 */
class WalletBalanceGateway implements PaymentGatewayInterface
{
    private array $config = [];

    // ── Identity ──────────────────────────────────────────────────────────────

    public function getCode(): string { return 'wallet_balance'; }
    public function getName(): string { return 'Wallet Balance'; }

    // ── Configuration ─────────────────────────────────────────────────────────

    public function getConfigSchema(): array
    {
        return [
            ['key' => 'enabled', 'label' => 'Enable Wallet Payments', 'type' => 'boolean', 'required' => false, 'sandbox_default' => 'true'],
        ];
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function validateConfig(array $config): array
    {
        return [];
    }

    public function isConfigured(): bool
    {
        return true;
    }

    // ── Payment initiation ────────────────────────────────────────────────────

    public function initializePayment(array $data): array
    {
        $reference = $data['reference'] ?? ('wallet_' . uniqid());

        Log::info('WalletBalanceGateway: payment initialised', [
            'reference' => $reference,
            'amount'    => $data['amount'] ?? null,
            'user_id'   => $data['user_id'] ?? null,
        ]);

        return [
            'direct_success'        => true,
            'requires_redirect'     => false,
            'transaction_reference' => $reference,
            'message'               => 'Payment deducted from wallet balance.',
        ];
    }

    // ── Verification ──────────────────────────────────────────────────────────

    public function verifyPayment(array $gatewayData, PaymentTransaction $transaction): array
    {
        Log::debug('WalletBalanceGateway: verifyPayment called (inline — always verified)', [
            'transaction_id' => $transaction->id,
        ]);

        return [
            'verified' => true,
            'status'   => 'completed',
            'raw'      => $gatewayData,
        ];
    }

    // ── Webhook ───────────────────────────────────────────────────────────────

    public function handleWebhook(Request $request): array
    {
        Log::debug('WalletBalanceGateway: handleWebhook called (not applicable for internal gateway)');

        return [
            'verified' => false,
            'status'   => 'not_applicable',
            'raw'      => [],
        ];
    }

    // ── Refunds ───────────────────────────────────────────────────────────────

    public function refund(PaymentTransaction $transaction, float $amount, string $reason = ''): array
    {
        Log::info('WalletBalanceGateway: refund signalled (credit handled by WalletService)', [
            'transaction_id' => $transaction->id,
            'amount'         => $amount,
            'reason'         => $reason,
        ]);

        return [
            'success'          => true,
            'refund_reference' => 'wallet_refund_' . $transaction->id,
            'message'          => 'Wallet refund processed.',
        ];
    }

    // ── Features ──────────────────────────────────────────────────────────────

    public function getSupportedFeatures(): array
    {
        return ['refunds', 'partial_refunds'];
    }
}
