<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\PayoutAccount;
use App\Models\PayoutTransaction;
use App\Models\WalletTransaction;
use App\Services\PayoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class TutorWalletController extends Controller
{
    public function __construct(private readonly PayoutService $payoutService) {}

    // ── Wallet overview ───────────────────────────────────────────────────────

    public function index(Request $request): Response
    {
        $user   = $request->user()->load('wallet');
        $wallet = $user->wallet;

        $transactions = WalletTransaction::where('wallet_id', $wallet?->id)
            ->orderByDesc('created_at')
            ->paginate(20)
            ->through(fn ($t) => [
                'id'            => $t->id,
                'type'          => $t->type->value,
                'direction'     => $t->direction,
                'amount'        => (float) $t->amount,
                'balance_after' => (float) $t->balance_after,
                'description'   => $t->description,
                'reference'     => $t->reference,
                'created_at'    => $t->created_at->toIso8601String(),
            ]);

        return Inertia::render('Tutor/Wallet/Index', [
            'balance'        => (float) ($wallet?->balance ?? 0),
            'escrow_balance' => (float) ($wallet?->escrow_balance ?? 0),
            'transactions'   => $transactions,
        ]);
    }

    // ── Payouts page ──────────────────────────────────────────────────────────

    public function payouts(Request $request): Response
    {
        $user     = $request->user()->load('wallet');

        $accounts = PayoutAccount::where('user_id', $user->id)
            ->get()
            ->map(fn ($a) => [
                'id'           => $a->id,
                'account_type' => $a->account_type,
                'holder_name'  => $a->account_holder_name,
                'bank_name'    => $a->bank_name,
                'branch_code'  => $a->branch_code,
                'is_default'   => $a->is_default,
                'is_verified'  => $a->is_verified,
                'verified_at'  => $a->verified_at?->toDateString(),
            ]);

        $history = PayoutTransaction::where('user_id', $user->id)
            ->with('payoutAccount:id,bank_name,account_type')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->through(fn ($p) => [
                'id'             => $p->id,
                'amount'         => (float) $p->amount,
                'status'         => $p->status,
                'reference'      => $p->reference,
                'failure_reason' => $p->failure_reason,
                'created_at'     => $p->created_at->toIso8601String(),
                'processed_at'   => $p->processed_at?->toIso8601String(),
                'account'        => $p->payoutAccount
                    ? "{$p->payoutAccount->bank_name} ({$p->payoutAccount->account_type})"
                    : '—',
            ]);

        return Inertia::render('Tutor/Wallet/Payouts', [
            'balance'         => (float) ($user->wallet?->balance ?? 0),
            'payout_accounts' => $accounts,
            'payout_history'  => $history,
        ]);
    }

    // ── Withdrawal request ────────────────────────────────────────────────────

    public function requestPayout(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'amount'            => ['required', 'numeric', 'min:50'],
            'payout_account_id' => ['required', 'exists:payout_accounts,id'],
        ]);

        try {
            $this->payoutService->requestWithdrawal($request->user(), $data);
            return back()->with('success', 'Payout request submitted. Processing within 2–3 business days.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancelPayout(Request $request, PayoutTransaction $payout): RedirectResponse
    {
        try {
            $this->payoutService->cancelWithdrawal($request->user(), $payout);
            return back()->with('success', 'Payout request cancelled and funds returned to your wallet.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ── Payout accounts ───────────────────────────────────────────────────────

    public function savePayoutAccount(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'account_type'        => ['required', 'in:bank,payfast,paypal'],
            'account_holder_name' => ['required', 'string', 'max:255'],
            'account_number'      => ['required_if:account_type,bank', 'nullable', 'string'],
            'branch_code'         => ['required_if:account_type,bank', 'nullable', 'string', 'max:10'],
            'bank_name'           => ['required_if:account_type,bank', 'nullable', 'string', 'max:100'],
            'is_default'          => ['boolean'],
        ]);

        try {
            $this->payoutService->createAccount($request->user(), $data);
            return back()->with('success', 'Payout account saved. An admin will verify it shortly.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function setDefaultAccount(Request $request, PayoutAccount $account): RedirectResponse
    {
        try {
            $this->payoutService->setDefaultAccount($request->user(), $account);
            return back()->with('success', 'Default payout account updated.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deletePayoutAccount(Request $request, PayoutAccount $account): RedirectResponse
    {
        try {
            $this->payoutService->deleteAccount($request->user(), $account);
            return back()->with('success', 'Payout account removed.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}