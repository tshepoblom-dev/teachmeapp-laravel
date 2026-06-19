<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ConsentController extends Controller
{
    /** Show the consent gate for already-logged-in users who lack consent. */
    public function show(): Response
    {
        return Inertia::render('Legal/ConsentGate');
    }

    /** Persist consent and redirect to the user's dashboard. */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'terms_accepted'   => ['required', 'accepted'],
            'privacy_accepted' => ['required', 'accepted'],
        ], [
            'terms_accepted.accepted'   => 'You must accept the Terms of Service.',
            'privacy_accepted.accepted' => 'You must accept the Privacy Policy.',
        ]);

        $user = $request->user();

        $user->update([
            'consent_accepted_at' => now(),
            'consent_ip'          => $request->ip(),
            'consent_user_agent'  => substr((string) $request->userAgent(), 0, 500),
        ]);

        Log::info('POPIA consent recorded for existing user', ['user_id' => $user->id]);

        return $this->redirectByRole($user->role->value);
    }

    private function redirectByRole(string $role): RedirectResponse
    {
        return match ($role) {
            'tutor'   => redirect()->route('tutor.dashboard'),
            'admin'   => redirect()->route('admin.dashboard'),
            default   => redirect()->route('student.dashboard'),
        };
    }
}