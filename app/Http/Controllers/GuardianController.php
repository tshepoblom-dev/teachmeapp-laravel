<?php

namespace App\Http\Controllers;

use App\Models\ParentUserGuardian;
use App\Services\GuardianService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class GuardianController extends Controller
{
    public function __construct(private readonly GuardianService $guardianService) {}

    // ─── Index ────────────────────────────────────────────────────────────────

    public function index(Request $request): Response
    {
        $links = $this->guardianService
            ->guardiansFor($request->user())
            ->map(fn ($l) => [
                'id'                  => $l->id,
                'guardian_name'       => $l->guardian?->name,
                'guardian_email'      => $l->guardian?->email,
                'relationship'        => $l->relationship,
                'can_book_sessions'   => $l->can_book_sessions,
                'can_receive_reports' => $l->can_receive_reports,
                'is_primary_contact'  => $l->is_primary_contact,
                'consent_provided_at' => $l->consent_provided_at?->toDateString(),
            ]);

        return Inertia::render('Student/Guardians/Index', [
            'guardians' => $links,
        ]);
    }

    // ─── Link ─────────────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'guardian_email'      => ['required', 'email'],
            'relationship'        => ['required', 'string', 'in:parent,legal_guardian,sibling,other'],
            'can_book_sessions'   => ['boolean'],
            'can_receive_reports' => ['boolean'],
            'is_primary_contact'  => ['boolean'],
        ]);

        try {
            $this->guardianService->link($request->user(), $data, $request->ip());
            return back()->with('success', 'Guardian linked successfully.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ─── Update permissions ───────────────────────────────────────────────────

    public function update(Request $request, ParentUserGuardian $guardian): RedirectResponse
    {
        $data = $request->validate([
            'can_book_sessions'   => ['boolean'],
            'can_receive_reports' => ['boolean'],
            'is_primary_contact'  => ['boolean'],
        ]);

        try {
            $this->guardianService->updatePermissions($request->user(), $guardian, $data);
            return back()->with('success', 'Guardian permissions updated.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ─── Unlink ───────────────────────────────────────────────────────────────

    public function destroy(Request $request, ParentUserGuardian $guardian): RedirectResponse
    {
        try {
            $this->guardianService->unlink($request->user(), $guardian);
            return back()->with('success', 'Guardian unlinked.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}