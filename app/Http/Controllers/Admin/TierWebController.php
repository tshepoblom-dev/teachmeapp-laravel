<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTierRequest;
use App\Http\Requests\UpdateTierRequest;
use App\Models\TutorTier;
use App\Services\TierService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TierWebController extends Controller
{
    public function __construct(
        private readonly TierService $tierService,
    ) {}

    public function index(): Response
    {
        $tiers = TutorTier::withCount(['profiles as tutor_count'])
            ->orderBy('display_order')
            ->get();

        return Inertia::render('Admin/Tiers/Index', [
            'tiers'      => $tiers,
            'pendingKyc' => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Tiers/Form', [
            'tier'       => null,
            'pendingKyc' => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function store(CreateTierRequest $request): RedirectResponse
    {
        $tier = $this->tierService->create($request->validated());

        return redirect()->route('admin.tiers.index')
            ->with('success', "Tier '{$tier->name}' created.");
    }

    public function edit(TutorTier $tier): Response
    {
        return Inertia::render('Admin/Tiers/Form', [
            'tier'       => $tier,
            'pendingKyc' => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function update(UpdateTierRequest $request, TutorTier $tier): RedirectResponse
    {
        $this->tierService->update($tier, $request->validated());

        return redirect()->route('admin.tiers.index')
            ->with('success', "Tier '{$tier->name}' updated.");
    }

    public function destroy(TutorTier $tier): RedirectResponse
    {
        try {
            $this->tierService->delete($tier);
            return redirect()->route('admin.tiers.index')
                ->with('success', "Tier deleted.");
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}