<?php

namespace App\Providers;

use App\Contracts\PaymentGatewayInterface;
use App\Services\Payment\GatewayManager;
use App\Services\Payment\Gateways\OzowGateway;
use App\Services\Payment\Gateways\PayFastGateway;
use App\Services\Payment\Gateways\WalletBalanceGateway;
use Illuminate\Support\ServiceProvider;

/**
 * Payment Gateway Service Provider
 *
 * Registers every gateway driver and wires them into the GatewayManager singleton.
 *
 * How to add a new gateway:
 *   1. Create MyGateway implements PaymentGatewayInterface in Services/Payment/Gateways/
 *   2. Bind it here and add it to the $drivers array below.
 *   3. Run php artisan db:seed --class=PaymentMethodSeeder (or add a migration).
 *   Done — no changes needed anywhere else.
 */
class PaymentGatewayServiceProvider extends ServiceProvider
{
    /**
     * All gateway driver classes.
     * Add new gateways to this array only.
     *
     * @var class-string<PaymentGatewayInterface>[]
     */
    private array $drivers = [
        PayFastGateway::class,
        OzowGateway::class,
        WalletBalanceGateway::class,
    ];

    public function register(): void
    {
        // Bind each driver as a singleton so config injection persists
        foreach ($this->drivers as $driverClass) {
            $this->app->singleton($driverClass);
        }

        // Register the GatewayManager as a singleton
        $this->app->singleton(GatewayManager::class, function ($app) {
            $manager = new GatewayManager();

            // Register every driver
            foreach ($this->drivers as $driverClass) {
                $manager->register($app->make($driverClass));
            }

            return $manager;
        });
    }

    public function boot(): void
    {
        // Defer config loading until after the DB connection is available.
        // This prevents boot-time failures when the application first runs (e.g., during migrations).
        $this->callAfterResolving(GatewayManager::class, function (GatewayManager $manager) {
            try {
                $manager->loadConfiguration();
            } catch (\Throwable $e) {
                // Graceful degradation during install/migration runs
                \Illuminate\Support\Facades\Log::warning(
                    'PaymentGatewayServiceProvider: Could not load gateway configs (DB may not be ready).',
                    ['error' => $e->getMessage()]
                );
            }
        });
    }
}
