<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Enums\SessionStatus;
use App\Models\Session;
use App\Services\SessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TutorSessionController extends Controller
{
    public function __construct(private readonly SessionService $sessionService) {}

    public function show(Request $request, Session $session): Response|RedirectResponse
    {
        $session->load('booking.student:id,name');
        abort_unless($session->booking->tutor_id === $request->user()->id, 403);

        // Guard: block expired sessions (scheduled window passed, never started)
        if ($session->isExpired()) {
            return redirect()
                ->route('tutor.bookings.show', $session->booking->id)
                ->with('error', 'This session has expired. The scheduled time and duration have passed without the session starting.');
        }

        // Guard: don't call join() if session is already ended/abandoned
        $tokenData = null;
        if ($session->status->isJoinable()) {
            try {
                $tokenData = $this->sessionService->join($session, $request->user());
            } catch (\Throwable $e) {
                // Early / ended — pass null token; Vue page handles it gracefully
            }
        }

        return Inertia::render('Tutor/Sessions/Show', [
            'session' => [
                'id'           => $session->id,
                'status'       => $session->status->value,
                'status_label' => $session->status->label(),
                'channel_name' => $session->agora_channel_name,
                'agora_token'  => $tokenData['token']     ?? null,
                'agora_uid'    => $tokenData['uid']       ?? null,
                'started_at'   => $session->started_at?->toIso8601String(),
                'ended_at'     => $session->ended_at?->toIso8601String(),
                'booking'      => [
                    'id'           => $session->booking->id,
                    'subject'      => $session->booking->subject,
                    'duration'     => $session->booking->duration_minutes,
                    'student_name' => $session->booking->student->name,
                    'scheduled_at' => $session->booking->scheduled_at
                        ->copy()->setTimezone(config('app.timezone'))->toIso8601String(),
                ],
            ],
            'agora_app_id' => config('agora.app_id'),
        ]);
    }

    public function start(Request $request, Session $session): RedirectResponse
    {
        $session->load('booking');
        abort_unless($session->booking->tutor_id === $request->user()->id, 403);

        try {
            $this->sessionService->start($session, $request->user());
            return back()->with('success', 'Session started.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function end(Request $request, Session $session): RedirectResponse
    {
        $session->load('booking');
        abort_unless($session->booking->tutor_id === $request->user()->id, 403);
        $request->validate(['reason' => 'nullable|string|max:500']);

        try {
            $this->sessionService->end($session, $request->user(), $request->reason);
            return redirect()
                ->route('tutor.bookings.show', $session->booking_id)
                ->with('success', 'Session ended. Earnings will be credited shortly.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
