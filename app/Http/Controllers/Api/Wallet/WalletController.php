<?php

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\WalletTransactionResource;
use App\Models\PaymentMethod;
use App\Models\WalletTransaction;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    use ApiResponse;

    // ── GET /api/wallet ───────────────────────────────────────────────────────

    public function index(Request $request): JsonResponse
    {
        $user   = $request->user()->load('wallet');
        $wallet = $user->wallet;

        $data = [
            'balance'        => (float) ($wallet?->balance ?? 0),
            'escrow_balance' => (float) ($wallet?->escrow_balance ?? 0),
            'currency'       => $wallet?->currency ?? 'ZAR',
        ];

        if ($user->isStudent()) {
            $methods = PaymentMethod::where('is_active', true)
                ->whereNotIn('code', ['wallet_balance'])
                ->orderBy('display_order')
                ->get();

            $data['payment_methods'] = PaymentMethodResource::collection($methods);
        }

        return $this->success($data);
    }

    // ── GET /api/wallet/transactions ──────────────────────────────────────────

    public function transactions(Request $request): JsonResponse
    {
        $wallet = $request->user()->load('wallet')->wallet;

        $transactions = WalletTransaction::where('wallet_id', $wallet?->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return $this->success(
            WalletTransactionResource::collection($transactions)->response()->getData(true)
        );
    }
}
