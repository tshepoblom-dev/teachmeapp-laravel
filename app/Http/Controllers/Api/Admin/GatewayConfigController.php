<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateGatewayConfigRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentGatewayConfiguration;
use App\Models\PaymentMethod;
use App\Services\Payment\GatewayManager;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Admin-only controller for payment gateway configuration.
 *
 * All routes require: auth:sanctum + account.active + middleware('admin')
 * (admin middleware added in routes/api.php via closure or dedicated class)
 */
class GatewayConfigController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly GatewayManager $gatewayManager) {}

    // ── GET /api/admin/payment/gateways ───────────────────────────────────────

    /**
     * List all registered gateways with their DB record, config status, and schema.
     */
    public function index(): JsonResponse
    {
        $methods = PaymentMethod::orderBy('display_order')->get()->keyBy('code');

        $gateways = collect($this->gatewayManager->registeredCodes())->map(function ($code) use ($methods) {
            $method  = $methods->get($code);
            $gateway = $this->gatewayManager->driverUnchecked($code);

            return [
                'code'          => $code,
                'name'          => $gateway->getName(),
                'is_registered' => true,
                'is_active'     => $method?->is_active ?? false,
                'is_configured' => $gateway->isConfigured(),
                'features'      => $gateway->getSupportedFeatures(),
                'config_schema' => $gateway->getConfigSchema(),
                'method'        => $method ? new PaymentMethodResource($method) : null,
            ];
        });

        return $this->success($gateways, 'Gateways retrieved.');
    }

    // ── GET /api/admin/payment/gateways/{code} ────────────────────────────────

    /**
     * Return full details for a single gateway, including current config keys
     * (values are masked for security — never returned in plain text).
     */
    public function show(string $code): JsonResponse
    {
        try {
            $gateway = $this->gatewayManager->driverUnchecked($code);
            $method  = PaymentMethod::where('code', $code)->first();

            $environment = config('app.env') === 'production' ? 'production' : 'sandbox';

            $configuredKeys = PaymentGatewayConfiguration::where('environment', $environment)
                ->whereHas('paymentMethod', fn ($q) => $q->where('code', $code))
                ->pluck('config_key')
                ->all();

            return $this->success([
                'code'           => $code,
                'name'           => $gateway->getName(),
                'is_active'      => $method?->is_active ?? false,
                'is_configured'  => $gateway->isConfigured(),
                'features'       => $gateway->getSupportedFeatures(),
                'config_schema'  => $gateway->getConfigSchema(),
                'configured_keys'=> $configuredKeys,
                'environment'    => $environment,
                'method'         => $method ? new PaymentMethodResource($method) : null,
            ], 'Gateway details retrieved.');

        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    // ── POST /api/admin/payment/gateways/{code}/configure ────────────────────

    /**
     * Upsert encrypted configuration for a gateway.
     *
     * Body: { environment: 'sandbox'|'production', config: { key: value, ... } }
     */
    public function configure(UpdateGatewayConfigRequest $request, string $code): JsonResponse
    {
        try {
            $gateway     = $this->gatewayManager->driverUnchecked($code);
            $environment = $request->input('environment');
            $config      = $request->input('config', []);

            // Validate via gateway's own rules
            $errors = $gateway->validateConfig($config);
            if (! empty($errors)) {
                return $this->error('Gateway configuration validation failed.', 422, $errors);
            }

            $method = PaymentMethod::where('code', $code)->firstOrFail();

            DB::transaction(function () use ($method, $environment, $config, $request) {
                foreach ($config as $key => $value) {
                    if ($value === null || $value === '') continue; // Don't overwrite with empty

                    PaymentGatewayConfiguration::updateOrCreate(
                        [
                            'payment_method_id' => $method->id,
                            'environment'       => $environment,
                            'config_key'        => $key,
                        ],
                        [
                            'config_value_encrypted' => Crypt::encryptString($value),
                            'updated_by'             => $request->user()->id,
                        ]
                    );
                }
            });

            // Reload config into the gateway
            $this->gatewayManager->loadConfiguration();

            return $this->success(null, "Gateway [{$code}] configuration updated for [{$environment}].");

        } catch (Throwable $e) {
            return $this->error('Configuration update failed: ' . $e->getMessage(), 422);
        }
    }

    // ── POST /api/admin/payment/gateways/{code}/toggle ────────────────────────

    /**
     * Enable or disable a gateway.
     * Body: { is_active: true|false }
     */
    public function toggle(Request $request, string $code): JsonResponse
    {
        $request->validate(['is_active' => ['required', 'boolean']]);

        try {
            $method = PaymentMethod::where('code', $code)->firstOrFail();
            $method->update(['is_active' => $request->boolean('is_active')]);

            $status = $method->is_active ? 'enabled' : 'disabled';
            return $this->success(new PaymentMethodResource($method), "Gateway [{$code}] {$status}.");

        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // ── POST /api/admin/payment/gateways/{code}/test ──────────────────────────

    /**
     * Validate the current configuration without making a real payment.
     */
    public function test(string $code): JsonResponse
    {
        try {
            $gateway = $this->gatewayManager->driverUnchecked($code);
            $isReady = $gateway->isConfigured();

            return $this->success([
                'code'          => $code,
                'is_configured' => $isReady,
                'features'      => $gateway->getSupportedFeatures(),
                'message'       => $isReady
                    ? 'All required credentials are present.'
                    : 'One or more required credentials are missing.',
            ], $isReady ? 'Gateway is ready.' : 'Gateway is not fully configured.');

        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 404);
        }
    }
}
