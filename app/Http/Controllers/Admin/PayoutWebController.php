<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycApplication;
use App\Models\PayoutAccount;
use App\Models\PayoutTransaction;
use App\Services\PayoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class PayoutWebController extends Controller
{
    public function __construct(private readonly PayoutService $payoutService) {}

    public function index(Request $request): Response
    {
        $payouts = PayoutTransaction::with(['user:id,name,email', 'payoutAccount'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20)
            ->withQueryString()
            ->through(fn ($p) => [
                'id'              => $p->id,
                'status'          => $p->status,
                'amount'          => (float) $p->amount,
                'reference'       => $p->reference,
                'external_payout_id' => $p->external_payout_id,
                'tutor'           => $p->user?->name,
                'tutor_email'     => $p->user?->email,
                'account_type'    => $p->payoutAccount?->account_type,
                'bank_name'       => $p->payoutAccount?->bank_name,
                'branch_code'     => $p->payoutAccount?->branch_code,
                'holder_name'     => $p->payoutAccount?->account_holder_name,
                'processed_at'    => $p->processed_at?->toDateString(),
                'created_at'      => $p->created_at->toDateString(),
                'failure_reason'  => $p->failure_reason,
            ]);

        $summary = [
            'pending'    => (float) PayoutTransaction::where('status', 'pending')->sum('amount'),
            'processing' => (float) PayoutTransaction::where('status', 'processing')->sum('amount'),
            'completed'  => (float) PayoutTransaction::where('status', 'completed')->sum('amount'),
        ];

        // Unverified payout accounts needing admin review
        $unverifiedAccounts = PayoutAccount::with('user:id,name,email')
            ->where('is_verified', false)
            ->latest()
            ->get()
            ->map(fn ($a) => [
                'id'           => $a->id,
                'account_type' => $a->account_type,
                'holder_name'  => $a->account_holder_name,
                'bank_name'    => $a->bank_name,
                'branch_code'  => $a->branch_code,
                'tutor'        => $a->user?->name,
                'tutor_email'  => $a->user?->email,
                'created_at'   => $a->created_at->toDateString(),
            ]);

        return Inertia::render('Admin/Payouts/Index', [
            'payouts'             => $payouts,
            'summary'             => $summary,
            'filters'             => $request->only(['status']),
            'pendingKyc'          => KycApplication::where('status', 'pending')->count(),
            'unverified_accounts' => $unverifiedAccounts,
        ]);
    }

    public function markProcessing(PayoutTransaction $payout): RedirectResponse
    {
        try {
            $this->payoutService->markProcessing($payout, request()->user());
            Log::info('PayoutWebController: payout marked processing', ['payout_id' => $payout->id, 'admin_id' => request()->user()->id]);
            return back()->with('success', "Payout #{$payout->id} marked as processing.");
        } catch (RuntimeException $e) {
            Log::error('PayoutWebController: markProcessing failed', ['payout_id' => $payout->id, 'error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function markCompleted(Request $request, PayoutTransaction $payout): RedirectResponse
    {
        $request->validate([
            'external_payout_id' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $this->payoutService->markCompleted($payout, $request->user(), $request->external_payout_id);
            Log::info('PayoutWebController: payout marked completed', ['payout_id' => $payout->id, 'admin_id' => $request->user()->id, 'external_id' => $request->external_payout_id]);
            return back()->with('success', "Payout #{$payout->id} completed.");
        } catch (RuntimeException $e) {
            Log::error('PayoutWebController: markCompleted failed', ['payout_id' => $payout->id, 'error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function markFailed(Request $request, PayoutTransaction $payout): RedirectResponse
    {
        $request->validate([
            'failure_reason' => ['required', 'string', 'max:500'],
        ]);

        try {
            $this->payoutService->markFailed($payout, $request->user(), $request->failure_reason);
            Log::warning('PayoutWebController: payout marked failed', ['payout_id' => $payout->id, 'admin_id' => $request->user()->id, 'reason' => $request->failure_reason]);
            return back()->with('success', "Payout #{$payout->id} marked as failed. Tutor wallet refunded.");
        } catch (RuntimeException $e) {
            Log::error('PayoutWebController: markFailed failed', ['payout_id' => $payout->id, 'error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function verifyAccount(PayoutAccount $account): RedirectResponse
    {
        try {
            $this->payoutService->verifyAccount($account, request()->user());
            Log::info('PayoutWebController: payout account verified', ['account_id' => $account->id, 'admin_id' => request()->user()->id]);
            return back()->with('success', "Payout account #{$account->id} verified.");
        } catch (RuntimeException $e) {
            Log::error('PayoutWebController: verifyAccount failed', ['account_id' => $account->id, 'error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function unverifyAccount(PayoutAccount $account): RedirectResponse
    {
        try {
            $this->payoutService->unverifyAccount($account, request()->user());
            Log::info('PayoutWebController: payout account unverified', ['account_id' => $account->id, 'admin_id' => request()->user()->id]);
            return back()->with('success', "Payout account #{$account->id} verification revoked.");
        } catch (RuntimeException $e) {
            Log::error('PayoutWebController: unverifyAccount failed', ['account_id' => $account->id, 'error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }
}
