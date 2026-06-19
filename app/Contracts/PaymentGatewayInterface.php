<?php

namespace App\Contracts;

use App\Models\PaymentTransaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * Contract that every payment gateway driver must implement.
 *
 * Design goals:
 *  - Core business logic (bookings, wallet, escrow) never imports a concrete gateway.
 *  - New gateways require zero changes to existing code; register in the service provider.
 *  - Each method is typed so the GatewayManager can enforce the contract at compile time.
 */
interface PaymentGatewayInterface
{
    // ── Identity ─────────────────────────────────────────────────────────────

    /** Unique machine-readable identifier — matches payment_methods.code */
    public function getCode(): string;

    /** Human-readable display name */
    public function getName(): string;

    // ── Configuration ─────────────────────────────────────────────────────────

    /**
     * JSON schema that the admin panel renders into a configuration form.
     *
     * Each field: { key, label, type: string|password|boolean, required, sandbox_default?, production_default? }
     *
     * @return array<int, array<string, mixed>>
     */
    public function getConfigSchema(): array;

    /**
     * Inject runtime configuration (decrypted values from payment_gateway_configurations).
     *
     * @param array<string, string> $config
     */
    public function setConfig(array $config): void;

    /**
     * Validate the supplied config values before persisting them.
     *
     * @param  array<string, string> $config
     * @return array<string, string>  Validation errors keyed by config_key; empty on success.
     */
    public function validateConfig(array $config): array;

    /** Returns true when all required credentials are present and non-empty. */
    public function isConfigured(): bool;

    // ── Payment initiation ────────────────────────────────────────────────────

    /**
     * Initiate a payment.
     *
     * @param  array{
     *   amount: float,
     *   currency: string,
     *   description: string,
     *   return_url: string,
     *   cancel_url: string,
     *   notify_url: string,
     *   user_email: string,
     *   user_name: string,
     *   reference: string,
     *   metadata?: array<string, mixed>,
     * } $data
     * @return array{
     *   requires_redirect?: bool,
     *   redirect_url?: string,
     *   form_fields?: array<string, string>,
     *   requires_confirmation?: bool,
     *   client_secret?: string,
     *   direct_success?: bool,
     *   transaction_reference?: string,
     *   message?: string,
     * }
     */
    public function initializePayment(array $data): array;

    // ── Verification & webhooks ───────────────────────────────────────────────

    /**
     * Verify a payment after the gateway redirects the user back.
     *
     * @param  array<string, mixed> $gatewayData  Query string or POST data from the redirect
     * @param  PaymentTransaction   $transaction
     * @return array{ verified: bool, status: string, gateway_reference?: string, raw?: array }
     */
    public function verifyPayment(array $gatewayData, PaymentTransaction $transaction): array;

    /**
     * Handle an asynchronous webhook / ITN from the gateway.
     *
     * @param  Request $request  The raw inbound request
     * @return array{ verified: bool, status: string, reference?: string, amount?: float, raw?: array }
     */
    public function handleWebhook(Request $request): array;

    // ── Refunds ───────────────────────────────────────────────────────────────

    /**
     * Initiate a refund for a completed payment.
     *
     * @param  PaymentTransaction $transaction
     * @param  float              $amount   Partial or full refund
     * @param  string             $reason
     * @return array{ success: bool, refund_reference?: string, message?: string }
     */
    public function refund(PaymentTransaction $transaction, float $amount, string $reason = ''): array;

    // ── Capability flags ─────────────────────────────────────────────────────

    /**
     * Array of supported features for this gateway.
     *
     * Possible values: 'refunds', 'webhooks', 'partial_refunds', 'recurring', 'tokenization'
     *
     * @return string[]
     */
    public function getSupportedFeatures(): array;
}
