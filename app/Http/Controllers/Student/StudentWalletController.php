<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\WalletTransaction;
use App\Services\Payment\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class StudentWalletController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService) {}

    public function index(Request $request): InertiaResponse
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
                'created_at'    => $t->created_at->toIso8601String(),
            ]);

        $methods = PaymentMethod::where('is_active', true)
            ->whereNotIn('code', ['wallet_balance'])
            ->orderBy('display_order')
            ->get()
            ->map(fn ($m) => ['id' => $m->id, 'code' => $m->code, 'name' => $m->name]);

        return Inertia::render('Student/Wallet/Index', [
            'balance'         => (float) ($wallet?->balance ?? 0),
            'escrow_balance'  => (float) ($wallet?->escrow_balance ?? 0),
            'transactions'    => $transactions,
            'payment_methods' => $methods,
        ]);
    }

    public function deposit(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $data = $request->validate([
            'amount'            => ['required', 'numeric', 'min:10'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
        ]);

        $method = PaymentMethod::findOrFail((int) $data['payment_method_id']);

        try {
            $result          = $this->paymentService->initiateDeposit(
                $request->user(),
                (float) $data['amount'],
                $method->code,
            );
            $gatewayResponse = $result['gateway_response'];

            if ($gatewayResponse['requires_redirect'] ?? false) {
                if (! empty($gatewayResponse['form_fields'])) {
                    // Store the PayFast form data in the session, then use
                    // Inertia::location() to trigger a true browser GET (not an
                    // Inertia XHR). The intermediate gatewayRedirect route reads
                    // the session and serves a plain HTML auto-submit page. Because
                    // the browser loads it as a real document (not inside Inertia's
                    // srcdoc modal), the form submits to PayFast without hitting the
                    // sandbox restriction.
                    session([
                        'gateway_form_redirect' => [
                            'action' => $gatewayResponse['redirect_url'],
                            'fields' => $gatewayResponse['form_fields'],
                        ],
                    ]);

                    return Inertia::location(route('student.wallet.gateway-redirect'));
                }

                // Simple GET redirect (no form POST needed)
                return Inertia::location($gatewayResponse['redirect_url']);
            }

            return redirect()->route('student.wallet.index')
                ->with('success', 'Deposit of R' . number_format($data['amount'], 2) . ' initiated.');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Intermediate page: reads the gateway form data stored in the session and
     * serves a self-submitting HTML form directly to the browser.
     *
     * This route is reached via a real browser GET (triggered by Inertia::location),
     * so the response is loaded as a top-level document — not inside any iframe —
     * and the form submission is never sandboxed.
     *
     * Route (web middleware, no auth required so the redirect survives): GET /student/wallet/gateway-redirect
     * Name: student.wallet.gateway-redirect
     */
    public function gatewayRedirect(Request $request): \Illuminate\Http\Response|RedirectResponse
    {
        $redirectData = session()->pull('gateway_form_redirect');

        if (empty($redirectData['action']) || empty($redirectData['fields'])) {
            // Nothing to redirect to — send the user back to the wallet page.
            return redirect()->route('student.wallet.index')
                ->with('error', 'Payment session expired. Please try again.');
        }

        return $this->buildFormPost($redirectData['action'], $redirectData['fields']);
    }

    // ─────────────────────────────────────────────────────────────────────────

    private function buildFormPost(string $actionUrl, array $fields): \Illuminate\Http\Response
    {
        $inputs = '';
        foreach ($fields as $key => $value) {
            $inputs .= '<input type="hidden" name="'
                . htmlspecialchars($key, ENT_QUOTES)
                . '" value="'
                . htmlspecialchars((string) $value, ENT_QUOTES)
                . '">';
        }

        $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redirecting to payment gateway…</title>
    <style>
        body { font-family: sans-serif; display: flex; flex-direction: column;
               align-items: center; justify-content: center; min-height: 100vh;
               margin: 0; background: #f9fafb; color: #374151; }
        .spinner { width: 40px; height: 40px; border: 3px solid #e5e7eb;
                   border-top-color: #0d9488; border-radius: 50%;
                   animation: spin 0.8s linear infinite; margin-bottom: 1.5rem; }
        @keyframes spin { to { transform: rotate(360deg); } }
        p { font-size: 0.95rem; color: #6b7280; }
    </style>
</head>
<body>
    <div class="spinner"></div>
    <p>Redirecting to payment gateway, please wait&hellip;</p>
    <form id="gw" method="POST" action="{$actionUrl}">{$inputs}</form>
    <script>document.getElementById('gw').submit();</script>
</body>
</html>
HTML;

        return response($html, 200, ['Content-Type' => 'text/html; charset=UTF-8']);
    }
}
