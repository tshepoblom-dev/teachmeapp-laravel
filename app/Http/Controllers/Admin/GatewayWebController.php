<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Services\Payment\GatewayManager as PaymentGatewayManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GatewayWebController extends Controller
{
    public function __construct(
        private readonly PaymentGatewayManager $manager,
    ) {}

    public function index(): Response
    {
        $methods = PaymentMethod::orderBy('display_order')->get()->map(fn ($m) => [
            'id'          => $m->id,
            'code'        => $m->code,
            'name'        => $m->name,
            'is_active'   => $m->is_active,
            'is_default'  => $m->is_default,
            'payment_flow'=> $m->payment_flow,
            'is_configured' => $this->isConfigured($m->code),
        ]);

        return Inertia::render('Admin/Gateways/Index', [
            'methods'    => $methods,
            'pendingKyc' => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function show(PaymentMethod $method): Response
    {
        $configs = \App\Models\PaymentGatewayConfiguration::where('payment_method_id', $method->id)
            ->get()
            ->map(fn ($c) => [
                'id'          => $c->id,
                'environment' => $c->environment,
                'config_key'  => $c->config_key,
                // Never expose the decrypted value — only show masked version
                'is_set'      => ! empty($c->config_value_encrypted),
            ]);

       // AFTER
        try {
            $schema = $this->manager->driverUnchecked($method->code)->getConfigSchema();
        } catch (\Throwable) {
            $schema = [];
        }

        return Inertia::render('Admin/Gateways/Show', [
            'method'     => $method,
            'configs'    => $configs,
            'schema'     => $schema,
            'pendingKyc' => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function configure(Request $request, PaymentMethod $method): RedirectResponse
    {
        $request->validate([
            'environment' => ['required', 'in:sandbox,production'],
            'configs'     => ['required', 'array'],
            'configs.*.key'   => ['required', 'string'],
            'configs.*.value' => ['nullable', 'string'],
        ]);

        foreach ($request->configs as $config) {
            if ($config['value'] === null || $config['value'] === '') continue;

            \App\Models\PaymentGatewayConfiguration::updateOrCreate(
                [
                    'payment_method_id' => $method->id,
                    'environment'       => $request->environment,
                    'config_key'        => $config['key'],
                ],
                [
                    'config_value_encrypted' => encrypt($config['value']),
                    'updated_by'             => $request->user()->id,
                ]
            );
        }

        return back()->with('success', "{$method->name} configuration saved.");
    }

    public function toggle(PaymentMethod $method): RedirectResponse
    {
        $method->update(['is_active' => ! $method->is_active]);

        $state = $method->is_active ? 'enabled' : 'disabled';

        return back()->with('success', "{$method->name} has been {$state}.");
    }

   // AFTER
    private function isConfigured(string $code): bool
    {
        try {
            $gateway = $this->manager->driverUnchecked($code);
            return $gateway->isConfigured();
        } catch (\Throwable) {
            return false;
        }
    }
}