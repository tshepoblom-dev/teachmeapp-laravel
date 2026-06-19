<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Services\Payment\GatewayManager;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * WebhookController
 *
 * Single entry point for all asynchronous payment gateway notifications.
 * Route: POST /api/payment/webhook/{gateway}
 *
 * Important:
 *  - This endpoint is CSRF-exempt (see bootstrap/app.php exclusion).
 *  - It does NOT require Sanctum auth — gateways call it server-to-server.
 *  - It always returns HTTP 200 to the gateway (gateways retry on non-200).
 *  - Real processing is delegated to PaymentService; this controller only
 *    handles routing and error containment.
 */
class WebhookController extends Controller
{
    public function __construct(
        private readonly GatewayManager $gatewayManager,
        private readonly PaymentService  $paymentService,
    ) {}

    public function handle(Request $request, string $gateway): Response
    {
        Log::info("Webhook received for gateway: {$gateway}", [
            'ip'      => $request->ip(),
            'headers' => $request->headers->all(),
        ]);

        try {
            $driver = $this->gatewayManager->driverUnchecked($gateway);
            $result = $driver->handleWebhook($request);

            if ($result['verified']) {
                $this->paymentService->handleWebhookResult($gateway, $result);
            } else {
                Log::warning("Webhook verification failed for [{$gateway}]", $result);
            }

        } catch (Throwable $e) {
            // Log but do not expose error details to the gateway caller.
            // Always return 200 so the gateway does not keep retrying.
            Log::error("Webhook processing error for [{$gateway}]: " . $e->getMessage(), [
                'exception' => $e,
            ]);
        }

        // Gateways expect a 200 OK (often with body "OK" for PayFast).
        return response('OK', 200)->header('Content-Type', 'text/plain');
    }
}
