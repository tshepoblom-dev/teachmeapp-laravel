<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentGatewayInterface;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Ozow Gateway — instant EFT for South Africa.
 *
 * Flow:
 *   1. initializePayment() calls the Ozow Transaction API → receives a URL.
 *   2. Client redirects the user to that URL.
 *   3. Ozow POSTs a webhook to notify_url with the result.
 *   4. Ozow GETs the return_url with status query params.
 *
 * Docs: https://doc.ozow.com
 */
class OzowGateway implements PaymentGatewayInterface
{
    private array $config = [];

    // ── Identity ──────────────────────────────────────────────────────────────

    public function getCode(): string { return 'ozow'; }
    public function getName(): string { return 'Ozow (Instant EFT)'; }

    // ── Configuration ─────────────────────────────────────────────────────────

    public function getConfigSchema(): array
    {
        return [
            ['key' => 'site_code',    'label' => 'Site Code',      'type' => 'string',   'required' => true,  'sandbox_default' => 'OZOW-001'],
            ['key' => 'private_key',  'label' => 'Private Key',    'type' => 'password', 'required' => true,  'sandbox_default' => ''],
            ['key' => 'api_key',      'label' => 'API Key',        'type' => 'password', 'required' => true,  'sandbox_default' => ''],
            ['key' => 'sandbox',      'label' => 'Sandbox Mode',   'type' => 'boolean',  'required' => false, 'sandbox_default' => 'true', 'production_default' => 'false'],
        ];
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function validateConfig(array $config): array
    {
        $errors = [];
        if (empty($config['site_code']))   $errors['site_code']   = 'Site Code is required.';
        if (empty($config['private_key'])) $errors['private_key'] = 'Private Key is required.';
        if (empty($config['api_key']))     $errors['api_key']     = 'API Key is required.';
        return $errors;
    }

    public function isConfigured(): bool
    {
        return ! empty($this->config['site_code'])
            && ! empty($this->config['private_key'])
            && ! empty($this->config['api_key']);
    }

    // ── Internal helpers ──────────────────────────────────────────────────────

    private function isSandbox(): bool
    {
        return filter_var($this->config['sandbox'] ?? true, FILTER_VALIDATE_BOOLEAN);
    }

    private function apiBaseUrl(): string
    {
        return $this->isSandbox()
            ? 'https://api.ozow.com'
            : 'https://api.ozow.com';   // same base; sandbox is toggled via IsTest field
    }

    /**
     * Build SHA-512 hash over the concatenated fields (Ozow spec).
     *
     * @param array<string, string> $fields  Ordered as per Ozow docs
     */
    private function generateHash(array $fields): string
    {
        $concat     = implode('', array_values($fields));
        $privateKey = $this->config['private_key'] ?? '';
        return hash('sha512', $concat . $privateKey);
    }

    // ── Payment initiation ────────────────────────────────────────────────────

    public function initializePayment(array $data): array
    {
        $reference  = $data['reference'] ?? Str::uuid()->toString();
        $isSandbox  = $this->isSandbox();
        $amountStr  = number_format((float) $data['amount'], 2, '.', '');

        // Fields must be in this exact order for Ozow hash
        $hashFields = [
            'SiteCode'          => $this->config['site_code'],
            'CountryCode'       => 'ZA',
            'CurrencyCode'      => $data['currency'] ?? 'ZAR',
            'Amount'            => $amountStr,
            'TransactionReference'=> $reference,
            'BankReference'     => substr($data['description'], 0, 20),
            'Optional1'         => '',
            'Optional2'         => '',
            'Optional3'         => '',
            'Optional4'         => '',
            'Optional5'         => '',
            'IsTest'            => $isSandbox ? 'true' : 'false',
            'SuccessUrl'        => $data['return_url'],
            'ErrorUrl'          => $data['cancel_url'],
            'CancelUrl'         => $data['cancel_url'],
            'NotifyUrl'         => $data['notify_url'],
        ];

        $payload = array_merge($hashFields, [
            'HashCheck' => $this->generateHash($hashFields),
            'CustomerEmail' => $data['user_email'] ?? '',
            'CustomerMobileNumber' => '',
        ]);

        $response = Http::withHeaders([
            'ApiKey'       => $this->config['api_key'],
            'Accept'       => 'application/json',
        ])->post($this->apiBaseUrl() . '/PostTransaction', $payload);

        if (! $response->successful()) {
            Log::error('Ozow initializePayment failed', ['status' => $response->status(), 'body' => $response->body()]);
            return [
                'requires_redirect'     => false,
                'direct_success'        => false,
                'message'               => 'Ozow payment initialization failed. Please try again.',
                'transaction_reference' => $reference,
            ];
        }

        $result = $response->json();
        $paymentUrl = $result['paymentUrl'] ?? $result['url'] ?? null;

        return [
            'requires_redirect'     => true,
            'redirect_url'          => $paymentUrl,
            'form_fields'           => [],
            'transaction_reference' => $reference,
        ];
    }

    // ── Verification ──────────────────────────────────────────────────────────

    public function verifyPayment(array $gatewayData, PaymentTransaction $transaction): array
    {
        // Ozow sends status in return_url query params: ?Status=Complete&...
        $status = strtolower($gatewayData['Status'] ?? $gatewayData['status'] ?? '');

        $ourStatus = match($status) {
            'complete'  => 'completed',
            'cancelled' => 'cancelled',
            'error'     => 'failed',
            default     => 'pending',
        };

        $verified = $ourStatus === 'completed';

        if ($verified) {
            // Cross-verify the hash Ozow appends to the return URL
            $hashCheck = $gatewayData['Hash'] ?? $gatewayData['hash'] ?? '';
            $hashFields = [
                'SiteCode'             => $gatewayData['SiteCode']             ?? '',
                'TransactionId'        => $gatewayData['TransactionId']        ?? '',
                'TransactionReference' => $gatewayData['TransactionReference'] ?? '',
                'Amount'               => $gatewayData['Amount']               ?? '',
                'Status'               => $gatewayData['Status']               ?? '',
                'Optional1'            => $gatewayData['Optional1']            ?? '',
                'Optional2'            => $gatewayData['Optional2']            ?? '',
                'Optional3'            => $gatewayData['Optional3']            ?? '',
                'Optional4'            => $gatewayData['Optional4']            ?? '',
                'Optional5'            => $gatewayData['Optional5']            ?? '',
            ];
            $computed = $this->generateHash($hashFields);
            $verified = hash_equals($computed, $hashCheck);
        }

        return [
            'verified'          => $verified,
            'status'            => $ourStatus,
            'gateway_reference' => $gatewayData['TransactionId'] ?? null,
            'raw'               => $gatewayData,
        ];
    }

    // ── Webhook ───────────────────────────────────────────────────────────────

    public function handleWebhook(Request $request): array
    {
        $data = $request->post();
        Log::channel('stack')->info('Ozow webhook received', ['data' => $data]);

        $hashCheck  = $data['Hash'] ?? $data['hash'] ?? '';
        $hashFields = [
            'SiteCode'             => $data['SiteCode']             ?? '',
            'TransactionId'        => $data['TransactionId']        ?? '',
            'TransactionReference' => $data['TransactionReference'] ?? '',
            'Amount'               => $data['Amount']               ?? '',
            'Status'               => $data['Status']               ?? '',
            'Optional1'            => $data['Optional1']            ?? '',
            'Optional2'            => $data['Optional2']            ?? '',
            'Optional3'            => $data['Optional3']            ?? '',
            'Optional4'            => $data['Optional4']            ?? '',
            'Optional5'            => $data['Optional5']            ?? '',
        ];

        $computed = $this->generateHash($hashFields);
        if (! hash_equals($computed, $hashCheck)) {
            Log::warning('Ozow webhook: hash mismatch', ['data' => $data]);
            return ['verified' => false, 'status' => 'hash_mismatch', 'raw' => $data];
        }

        $status = strtolower($data['Status'] ?? '');
        $ourStatus = match($status) {
            'complete'  => 'completed',
            'cancelled' => 'cancelled',
            'error'     => 'failed',
            default     => 'pending',
        };

        return [
            'verified'  => true,
            'status'    => $ourStatus,
            'reference' => $data['TransactionReference'] ?? null,
            'amount'    => (float) ($data['Amount'] ?? 0),
            'raw'       => $data,
        ];
    }

    // ── Refunds ───────────────────────────────────────────────────────────────

    public function refund(PaymentTransaction $transaction, float $amount, string $reason = ''): array
    {
        // Ozow does not currently expose a refund API; refunds go through support.
        return [
            'success' => false,
            'message' => 'Ozow refunds must be requested through the Ozow merchant portal.',
        ];
    }

    // ── Features ──────────────────────────────────────────────────────────────

    public function getSupportedFeatures(): array
    {
        return ['webhooks'];
    }
}
