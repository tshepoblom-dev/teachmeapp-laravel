<?php

namespace App\Http\Controllers\Api\Payout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payout\RequestPayoutRequest;
use App\Http\Requests\Payout\SavePayoutAccountRequest;
use App\Http\Resources\PayoutAccountResource;
use App\Http\Resources\PayoutTransactionResource;
use App\Models\PayoutAccount;
use App\Models\PayoutTransaction;
use App\Services\PayoutService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class PayoutController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly PayoutService $payoutService) {}

    // ── GET /api/payout/accounts ──────────────────────────────────────────────

    public function accounts(Request $request): JsonResponse
    {
        $accounts = PayoutAccount::where('user_id', $request->user()->id)->get();

        return $this->success(PayoutAccountResource::collection($accounts));
    }

    // ── POST /api/payout/accounts ─────────────────────────────────────────────

    public function storeAccount(SavePayoutAccountRequest $request): JsonResponse
    {
        try {
            $account = $this->payoutService->createAccount($request->user(), $request->validated());
        } catch (RuntimeException $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(new PayoutAccountResource($account), 'Payout account saved. An admin will verify it shortly.', 201);
    }

    // ── POST /api/payout/accounts/{account}/default ──────────────────────────

    public function setDefaultAccount(Request $request, PayoutAccount $account): JsonResponse
    {
        abort_unless($account->user_id === $request->user()->id, 403);

        try {
            $this->payoutService->setDefaultAccount($request->user(), $account);
        } catch (RuntimeException $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(new PayoutAccountResource($account->fresh()), 'Default payout account updated.');
    }

    // ── DELETE /api/payout/accounts/{account} ─────────────────────────────────

    public function deleteAccount(Request $request, PayoutAccount $account): JsonResponse
    {
        abort_unless($account->user_id === $request->user()->id, 403);

        try {
            $this->payoutService->deleteAccount($request->user(), $account);
        } catch (RuntimeException $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(message: 'Payout account removed.');
    }

    // ── GET /api/payout/transactions ──────────────────────────────────────────

    public function transactions(Request $request): JsonResponse
    {
        $transactions = PayoutTransaction::where('user_id', $request->user()->id)
            ->with('payoutAccount:id,bank_name,account_type')
            ->orderByDesc('created_at')
            ->paginate(15);

        return $this->success(
            PayoutTransactionResource::collection($transactions)->response()->getData(true)
        );
    }

    // ── POST /api/payout/request ──────────────────────────────────────────────

    public function requestPayout(RequestPayoutRequest $request): JsonResponse
    {
        try {
            $payout = $this->payoutService->requestWithdrawal($request->user(), $request->validated());
        } catch (RuntimeException $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(new PayoutTransactionResource($payout), 'Payout request submitted. Processing within 2–3 business days.', 201);
    }

    // ── POST /api/payout/{payout}/cancel ──────────────────────────────────────

    public function cancelPayout(Request $request, PayoutTransaction $payout): JsonResponse
    {
        abort_unless($payout->user_id === $request->user()->id, 403);

        try {
            $payout = $this->payoutService->cancelWithdrawal($request->user(), $payout);
        } catch (RuntimeException $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(new PayoutTransactionResource($payout), 'Payout request cancelled and funds returned to your wallet.');
    }
}
