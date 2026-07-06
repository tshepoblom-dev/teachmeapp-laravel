<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\Models\PaymentGatewayConfiguration;
use App\Models\PaymentMethod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Central registry for all payment gateway drivers.
 *
 * The service provider registers every driver and tags them with 'payment.gateways'.
 * This manager resolves them by code, injects their configuration, and exposes
 * a uniform API to the rest of the application.
 *
 * Nothing outside this class (or the service provider) should ever reference
 * a concrete gateway class.
 */
class GatewayManager
{
    /** @var array<string, PaymentGatewayInterface> keyed by gateway code */
    private array $gateways = [];

    /**
     * Register a gateway driver with the manager.
     * Called by the service provider for each tagged driver.
     */
    public function register(PaymentGatewayInterface $gateway): void
    {
        $this->gateways[$gateway->getCode()] = $gateway;
        Log::debug('GatewayManager: gateway registered', ['code' => $gateway->getCode()]);
    }

    /**
     * Inject database configuration into every registered gateway.
     * Should be called once after the service container resolves all drivers.
     */
    public function loadConfiguration(): void
    {
        $environment = config('app.env') == 'production' ? 'production' : 'sandbox';

        Log::debug('GatewayManager: loading gateway configurations', [
            'environment'      => $environment,
            'registered_codes' => array_keys($this->gateways),
        ]);

        $configs = PaymentGatewayConfiguration::query()
            ->whereHas('paymentMethod', fn ($q) => $q->where('is_active', true))
            ->where('environment', $environment)
            ->get()
            ->groupBy(fn ($c) => $c->paymentMethod->code ?? null);

        foreach ($this->gateways as $code => $gateway) {
            /** @var Collection<int, PaymentGatewayConfiguration> $rows */
            $rows = $configs->get($code, collect());

            $configArray = $rows->mapWithKeys(function ($row) {
                $value = $row->config_value;
                if (is_string($value) && str_starts_with($value, 's:')) {
                    $value = unserialize($value);
                }
                return [$row->config_key => $value];
            })->all();

            // Never let a missing 'sandbox' key silently fall back to sandbox mode
            // in production — default it explicitly based on the environment that
            // was actually loaded, rather than relying on each gateway's own fallback.
            if (! array_key_exists('sandbox', $configArray)) {
                $configArray['sandbox'] = $environment !== 'production' ? 'true' : 'false';
            }

            $gateway->setConfig($configArray);

            Log::debug('GatewayManager: gateway configured', [
                'code'       => $code,
                'keys_found' => array_keys($configArray),
            ]);
        }
    }

    // ── Resolution ────────────────────────────────────────────────────────────

    /**
     * Resolve a gateway by its code.
     *
     * @throws RuntimeException when the gateway is not registered or not active in the DB.
     */
    public function driver(string $code): PaymentGatewayInterface
    {
        if (! isset($this->gateways[$code])) {
            Log::error('GatewayManager: driver not registered', ['code' => $code]);
            throw new RuntimeException("Payment gateway [{$code}] is not registered.");
        }

        $method = PaymentMethod::where('code', $code)->where('is_active', true)->first();

        if (! $method) {
            Log::warning('GatewayManager: gateway not active in DB', ['code' => $code]);
            throw new RuntimeException("Payment gateway [{$code}] is not active.");
        }

        $gateway = $this->gateways[$code];
        if (! $gateway->isConfigured()) {
            Log::warning('GatewayManager: gateway not configured', ['code' => $code]);
            throw new RuntimeException("Payment gateway [{$code}] is not configured. Check credentials in admin.");
        }

        Log::debug('GatewayManager: driver resolved', ['code' => $code]);
        return $this->gateways[$code];
    }

    /**
     * Resolve a gateway without checking DB activity (useful in webhooks).
     *
     * @throws RuntimeException when the gateway is not registered.
     */
    public function driverUnchecked(string $code): PaymentGatewayInterface
    {
        if (! isset($this->gateways[$code])) {
            Log::error('GatewayManager: driverUnchecked — not registered', ['code' => $code]);
            throw new RuntimeException("Payment gateway [{$code}] is not registered.");
        }

        return $this->gateways[$code];
    }

    // ── Listing ───────────────────────────────────────────────────────────────

    /**
     * All active gateways (joined with DB so we get name, logo, etc.)
     *
     * @return Collection<int, array{ method: PaymentMethod, gateway: PaymentGatewayInterface }>
     */
    public function active(): Collection
    {
        $methods = PaymentMethod::active()->get();

        return $methods->filter(
            fn ($m) => isset($this->gateways[$m->code])
        )->map(fn ($m) => [
            'method'  => $m,
            'gateway' => $this->gateways[$m->code],
        ])->values();
    }

    /**
     * All registered gateway codes.
     *
     * @return string[]
     */
    public function registeredCodes(): array
    {
        return array_keys($this->gateways);
    }

    /**
     * Returns true if the gateway code is registered AND marked active in the DB.
     */
    public function isAvailable(string $code): bool
    {
        if (! isset($this->gateways[$code])) {
            return false;
        }

        return PaymentMethod::where('code', $code)->where('is_active', true)->exists();
    }

    // ── Admin helpers ─────────────────────────────────────────────────────────

    /**
     * Return the config schema for every registered gateway, keyed by code.
     *
     * @return array<string, array>
     */
    public function allConfigSchemas(): array
    {
        return collect($this->gateways)
            ->mapWithKeys(fn ($gw, $code) => [$code => $gw->getConfigSchema()])
            ->all();
    }

    /**
     * Validate a proposed configuration for a given gateway.
     *
     * @param  array<string, string> $config
     * @return array<string, string>  Errors keyed by field; empty on success.
     */
    public function validateGatewayConfig(string $code, array $config): array
    {
        return $this->driverUnchecked($code)->validateConfig($config);
    }
}
