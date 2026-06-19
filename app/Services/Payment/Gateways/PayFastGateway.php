<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentGatewayInterface;
use App\Models\PayfastTransaction;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * PayFast Gateway — South African payment processor.
 *
 * Flow:
 *   1. initializePayment() builds the signed form-post payload → client auto-submits to PayFast.
 *   2. User completes payment on PayFast-hosted page.
 *   3. PayFast POSTs an ITN (Instant Transaction Notification) to our webhook URL.
 *   4. handleWebhook() verifies the ITN signature and marks the transaction complete.
 *   5. PayFast redirects the user to return_url (GET); verifyPayment() cross-checks.
 *
 * Docs: https://developers.payfast.co.za/docs
 */
class PayFastGateway implements PaymentGatewayInterface
{
    private array $config = [];

    // ── Identity ──────────────────────────────────────────────────────────────

    public function getCode(): string { return 'payfast'; }
    public function getName(): string { return 'PayFast'; }

    // ── Configuration ─────────────────────────────────────────────────────────

    public function getConfigSchema(): array
    {
        return [
            ['key' => 'merchant_id',  'label' => 'Merchant ID',  'type' => 'string',   'required' => true,  'sandbox_default' => '10000100'],
            ['key' => 'merchant_key', 'label' => 'Merchant Key', 'type' => 'password', 'required' => true,  'sandbox_default' => '46f0cd694581a'],
            ['key' => 'passphrase',   'label' => 'Passphrase',   'type' => 'password', 'required' => false, 'sandbox_default' => 'Teachmeapp2024'],
            ['key' => 'sandbox',      'label' => 'Sandbox Mode', 'type' => 'boolean',  'required' => false, 'sandbox_default' => 'true', 'production_default' => 'false'],
        ];
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function validateConfig(array $config): array
    {
        $errors = [];
        if (empty($config['merchant_id']))  $errors['merchant_id']  = 'Merchant ID is required.';
        if (empty($config['merchant_key'])) $errors['merchant_key'] = 'Merchant Key is required.';
        return $errors;
    }

    public function isConfigured(): bool
    {
        return ! empty($this->config['merchant_id']) && ! empty($this->config['merchant_key']);
    }

    // ── Internal helpers ──────────────────────────────────────────────────────

    private function isSandbox(): bool
    {
        return filter_var($this->config['sandbox'] ?? true, FILTER_VALIDATE_BOOLEAN);
    }

    private function baseUrl(): string
    {
        return $this->isSandbox()
            ? 'https://sandbox.payfast.co.za/eng/process'
            : 'https://www.payfast.co.za/eng/process';
    }

    private function validateUrl(): string
    {
        return $this->isSandbox()
            ? 'https://sandbox.payfast.co.za/eng/query/validate'
            : 'https://www.payfast.co.za/eng/query/validate';
    }

    /**
     * Build PayFast-compatible MD5 signature over a flat key=value array.
     *
     * @param array<string, string> $data
     */
    private function generateSignature(array $data): string
    {
        $pairs = [];
        foreach ($data as $k => $v) {
            if ($k === 'signature') continue;
            $pairs[] = $k . '=' . urlencode(trim((string) $v));
        }

        $str = implode('&', $pairs);

        $passphrase = $this->config['passphrase'] ?? '';
        if ($passphrase !== '') {
            $str .= '&passphrase=' . urlencode(trim($passphrase));
        }

        return md5($str);
    }

    // ── Payment initiation ────────────────────────────────────────────────────

    public function initializePayment(array $data): array
    {
        $reference = $data['reference'] ?? Str::uuid()->toString();

         $fields = [
            'merchant_id'  => $this->config['merchant_id'],
            'merchant_key' => $this->config['merchant_key'],
            'return_url'   => $this->enforceHttps($data['return_url']),
            'cancel_url'   => $this->enforceHttps($data['cancel_url']),
            'notify_url'   => $this->enforceHttps($data['notify_url']),
          //  'name_first'   => explode(' ', $data['user_name'])[0] ?? '',
          //  'name_last'    => explode(' ', $data['user_name'], 2)[1] ?? '',
          //  'email_address'=> $data['user_email'],
            'm_payment_id' => $reference,
            'amount'       => number_format((float) $data['amount'], 2, '.', ''),
            'item_name'    => substr($data['description'], 0, 100),
        ];

        $fields['signature'] = $this->generateSignature($fields);

        return [
            'requires_redirect'    => true,
            'redirect_url'         => $this->baseUrl(),
            'form_fields'          => $fields,
            'transaction_reference'=> $reference,
        ];
    }
    
    private function enforceHttps(string $url): string
    {
        return str_replace('http://', 'https://', $url);
    }
    // ── Verification ──────────────────────────────────────────────────────────

    public function verifyPayment(array $gatewayData, PaymentTransaction $transaction): array
    {
        // PayFast return_url is GET-only and carries no reliable status.
        // Real confirmation comes via ITN (webhook). We look up the PayFast record.
        $pfRecord = PayfastTransaction::where('payment_transaction_id', $transaction->id)->first();

        if ($pfRecord && $pfRecord->itn_verified && $pfRecord->payment_status === 'complete') {
            return [
                'verified'          => true,
                'status'            => 'completed',
                'gateway_reference' => $pfRecord->pf_payment_id,
                'raw'               => $gatewayData,
            ];
        }

        return [
            'verified' => false,
            'status'   => 'pending',
            'raw'      => $gatewayData,
        ];
    }

    // ── Webhook / ITN ─────────────────────────────────────────────────────────

    public function handleWebhook(Request $request): array
    {
        $data = $request->post();
        Log::channel('stack')->info('PayFast ITN received', ['data' => $data]);

        // 1 — Signature validation
        $calculatedSignature = $this->generateSignature($data);
        if (! hash_equals($calculatedSignature, $data['signature'] ?? '')) {
            Log::warning('PayFast ITN: signature mismatch', ['data' => $data]);
            return ['verified' => false, 'status' => 'signature_mismatch', 'raw' => $data];
        }

        // 2 — Server-side validation with PayFast
        $validationResponse = Http::asForm()->post($this->validateUrl(), $data);
        if (! $validationResponse->successful() || trim($validationResponse->body()) !== 'VALID') {
            Log::warning('PayFast ITN: server validation failed', ['response' => $validationResponse->body()]);
            return ['verified' => false, 'status' => 'validation_failed', 'raw' => $data];
        }

        // 3 — Amount verification is done in PaymentService against PaymentTransaction.amount

        $pfStatus   = strtolower($data['payment_status'] ?? '');
        $ourStatus  = match($pfStatus) {
            'complete'  => 'completed',
            'failed'    => 'failed',
            'cancelled' => 'cancelled',
            default     => 'pending',
        };

        return [
            'verified'   => true,
            'status'     => $ourStatus,
            'reference'  => $data['m_payment_id'] ?? null,
            'pf_payment_id' => $data['pf_payment_id'] ?? null,
            'amount'     => (float) ($data['amount_gross'] ?? 0),
            'amount_fee' => (float) ($data['amount_fee']   ?? 0),
            'amount_net' => (float) ($data['amount_net']   ?? 0),
            'raw'        => $data,
        ];
    }

    // ── Refunds ───────────────────────────────────────────────────────────────

    /**
     * PayFast does not expose a programmatic refund API as of 2024.
     * Refunds are processed manually through the merchant dashboard.
     */
    public function refund(PaymentTransaction $transaction, float $amount, string $reason = ''): array
    {
        return [
            'success' => false,
            'message' => 'PayFast refunds must be processed manually via the PayFast merchant dashboard.',
        ];
    }

    // ── Features ──────────────────────────────────────────────────────────────

    public function getSupportedFeatures(): array
    {
        return ['webhooks'];
    }
}
