<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\BookingPaymentRequest;
use App\Http\Requests\Payment\DepositRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\PaymentTransactionResource;
use App\Models\Booking;
use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use App\Services\Payment\GatewayManager;
use App\Services\Payment\PaymentService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class PaymentController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly GatewayManager $gatewayManager,
    ) {}

    // ── GET /api/payment/methods ──────────────────────────────────────────────

    /**
     * List all active payment methods, annotated with the user's preferences.
     */
    public function methods(Request $request): JsonResponse
    {
        $user    = $request->user();
        $methods = PaymentMethod::active()->get();

        $preferences = $user->paymentMethodPreferences()
            ->pluck('is_default', 'payment_method_id');

        $data = PaymentMethodResource::collection($methods)->map(function ($resource) use ($preferences, $user) {
            $arr                 = $resource->toArray(request());
            $arr['is_preferred'] = (bool) ($preferences[$arr['id']] ?? false);
            $arr['is_configured']= $this->gatewayManager->isAvailable($arr['code']);
            return $arr;
        });

        return $this->success($data, 'Payment methods retrieved.');
    }

    // ── POST /api/payment/deposit ─────────────────────────────────────────────

    /**
     * Initiate a wallet top-up.
     */
    public function deposit(DepositRequest $request): JsonResponse
    {
        $user = $request->user();

        Log::info('PaymentController: deposit initiated', [
            'user_id'        => $user->id,
            'amount'         => $request->input('amount'),
            'payment_method' => $request->input('payment_method'),
        ]);

        try {
            $result = $this->paymentService->initiateDeposit(
                $user,
                (float) $request->input('amount'),
                $request->input('payment_method')
            );

            Log::info('PaymentController: deposit initiated successfully', [
                'user_id'        => $user->id,
                'transaction_id' => $result['transaction']->id,
            ]);

            return $this->success([
                'transaction'      => new PaymentTransactionResource($result['transaction']->load('paymentMethod')),
                'gateway_response' => $result['gateway_response'],
            ], 'Deposit initiated.', 201);

        } catch (Throwable $e) {
            Log::error('PaymentController: deposit failed', [
                'user_id' => $user->id,
                'amount'  => $request->input('amount'),
                'error'   => $e->getMessage(),
            ]);
            return $this->error($e->getMessage(), 422);
        }
    }

    // ── POST /api/payment/booking/{booking} ───────────────────────────────────

    /**
     * Pay for a booking using the specified gateway.
     */
    public function payBooking(BookingPaymentRequest $request, Booking $booking): JsonResponse
    {
        $user = $request->user();

        Log::info('PaymentController: booking payment initiated', [
            'user_id'        => $user->id,
            'booking_id'     => $booking->id,
            'payment_method' => $request->input('payment_method'),
        ]);

        try {
            $result = $this->paymentService->initiateBookingPayment(
                $user,
                $booking,
                $request->input('payment_method')
            );

            Log::info('PaymentController: booking payment initiated successfully', [
                'user_id'        => $user->id,
                'booking_id'     => $booking->id,
                'transaction_id' => $result['transaction']->id,
            ]);

            return $this->success([
                'transaction'      => new PaymentTransactionResource($result['transaction']->load('paymentMethod')),
                'gateway_response' => $result['gateway_response'],
            ], 'Payment initiated.', 201);

        } catch (Throwable $e) {
            Log::error('PaymentController: booking payment failed', [
                'user_id'    => $user->id,
                'booking_id' => $booking->id,
                'error'      => $e->getMessage(),
            ]);
            return $this->error($e->getMessage(), 422);
        }
    }

    // ── GET /api/payment/callback/{gateway} ───────────────────────────────────

    /**
     * Gateway redirects the user here after payment (GET).
     * We delegate verification to the gateway and return a JSON result.
     */
    public function callback(Request $request, string $gateway): JsonResponse
    {
        Log::info('PaymentController: gateway callback received', [
            'gateway' => $gateway,
            'ref'     => $request->query('ref'),
        ]);

        try {
            $transactionId = $request->query('ref');
            $transaction   = PaymentTransaction::findOrFail($transactionId);

            $driver = $this->gatewayManager->driverUnchecked($gateway);
            $result = $driver->verifyPayment($request->all(), $transaction);

            Log::info('PaymentController: gateway callback verified', [
                'gateway'        => $gateway,
                'transaction_id' => $transaction->id,
                'verified'       => $result['verified'],
                'status'         => $result['status'],
            ]);

            if ($result['verified'] && $result['status'] === 'completed') {
                return $this->success(
                    new PaymentTransactionResource($transaction->fresh()->load('paymentMethod')),
                    'Payment verified.'
                );
            }

            return $this->success(
                new PaymentTransactionResource($transaction->fresh()->load('paymentMethod')),
                'Payment is pending confirmation.'
            );

        } catch (Throwable $e) {
            Log::error('PaymentController: gateway callback failed', [
                'gateway' => $gateway,
                'ref'     => $request->query('ref'),
                'error'   => $e->getMessage(),
            ]);
            return $this->error('Callback verification failed: ' . $e->getMessage(), 422);
        }
    }

    // ── GET /api/payment/transactions ─────────────────────────────────────────

    /**
     * List the authenticated user's payment transactions.
     */
    public function transactions(Request $request): JsonResponse
    {
        $transactions = PaymentTransaction::where('user_id', $request->user()->id)
            ->with('paymentMethod')
            ->orderByDesc('created_at')
            ->paginate(20);

        return $this->success(
            PaymentTransactionResource::collection($transactions)->response()->getData(true),
            'Transactions retrieved.'
        );
    }
}
