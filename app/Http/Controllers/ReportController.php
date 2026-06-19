<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Services\ReportService;
use App\Services\SessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class ReportController extends Controller
{
    public function __construct(
        private readonly ReportService  $reportService,
        private readonly SessionService $sessionService,
    ) {}

    /**
     * POST /sessions/{session}/report
     * Submitted by either the student or tutor during a session.
     *
     * When action_taken === 'end_session' we also end the session so both
     * parties are cleanly disconnected and escrow released.
     */
    public function store(Request $request, Session $session): RedirectResponse
    {
        $data = $request->validate([
            'reason'       => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'action_taken' => ['required', 'in:continue_session,end_session'],
        ]);

        try {
            $this->reportService->submit($request->user(), $session, $data);

            // If the reporter chose to end the session, do it now.
            if ($data['action_taken'] === 'end_session') {
                // Guard: only end sessions that are still running.
                if (in_array($session->status, ['waiting', 'active', 'in_progress'], true)) {
                    $this->sessionService->end(
                        session: $session,
                        actor:   $request->user(),
                        reason:  'Ended by participant after submitting a report.',
                    );
                }

                return redirect()
                    ->route('student.bookings.show', $session->booking_id)
                    ->with('success', 'Report submitted and session ended. Our team will review it shortly.');
            }

            return back()->with('success', 'Report submitted. Our team will review it shortly.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
