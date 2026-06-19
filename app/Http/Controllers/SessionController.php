<?php

namespace App\Http\Controllers;

use App\Http\Requests\EndSessionRequest;
use App\Http\Requests\JoinSessionRequest;
use App\Http\Requests\StartSessionRequest;
use App\Http\Resources\SessionResource;
use App\Models\Session;
use App\Services\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class SessionController extends Controller
{
    public function __construct(
        private readonly SessionService $sessionService,
    ) {}

    // =========================================================================
    // GET /api/sessions/{session}
    // View session details. Only participants and admins.
    // =========================================================================

    public function show(Request $request, Session $session): JsonResponse
    {
        $this->authorizeParticipant($request->user(), $session);

        $session->load(['booking.student', 'booking.tutor', 'agoraChannel']);

        return $this->success(new SessionResource($session));
    }

    // =========================================================================
    // POST /api/sessions/{session}/join
    // Get Agora token + channel details to enter the session.
    // Returns fresh token every time — tokens must not be cached client-side.
    // =========================================================================

    public function join(JoinSessionRequest $request, Session $session): JsonResponse
    {
        // Guard: block access to sessions whose scheduled window has passed
        // without ever progressing beyond Waiting status.
        if ($session->isExpired()) {
            return $this->error(
                'This session has expired. The scheduled time and duration have passed.',
                410   // 410 Gone — resource existed but is no longer available
            );
        }

        try {
            $joinData = $this->sessionService->join(
                session: $session,
                user: $request->user(),
            );

            return $this->success(
                data: $joinData,
                message: 'Session joined. Connect to the Agora channel using the token provided.',
            );
        } catch (Throwable $e) {
            Log::warning('Session join failed', [
                'session_id' => $session->id,
                'user_id'    => $request->user()->id,
                'error'      => $e->getMessage(),
            ]);

            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/sessions/{session}/start
    // Tutor explicitly starts the session — booking moves to in_progress.
    // =========================================================================

    public function start(StartSessionRequest $request, Session $session): JsonResponse
    {
        if ($session->isExpired()) {
            return $this->error(
                'This session has expired and can no longer be started.',
                410
            );
        }

        try {
            $session = $this->sessionService->start(
                session: $session,
                tutor: $request->user(),
            );

            return $this->success(
                data: new SessionResource($session->load(['booking', 'agoraChannel'])),
                message: 'Session started.',
            );
        } catch (Throwable $e) {
            Log::warning('Session start failed', [
                'session_id' => $session->id,
                'tutor_id'   => $request->user()->id,
                'error'      => $e->getMessage(),
            ]);

            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/sessions/{session}/end
    // Either party ends the session — escrow released to tutor.
    // =========================================================================

    public function end(EndSessionRequest $request, Session $session): JsonResponse
    {
        try {
            $session = $this->sessionService->end(
                session: $session,
                endedBy: $request->user(),
                reason: $request->validated('reason'),
            );

            return $this->success(
                data: new SessionResource($session->load(['booking.escrowTransaction'])),
                message: 'Session ended. Earnings have been released to the tutor wallet.',
            );
        } catch (Throwable $e) {
            Log::warning('Session end failed', [
                'session_id' => $session->id,
                'user_id'    => $request->user()->id,
                'error'      => $e->getMessage(),
            ]);

            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/sessions/{session}/keepalive
    // Client pings every 30s to signal active presence.
    // Used to detect abandoned sessions via checkAndAutoEnd().
    // =========================================================================

    public function keepalive(Request $request, Session $session): JsonResponse
    {
        try {
            $this->sessionService->keepalive(
                session: $session,
                user: $request->user(),
            );

            return $this->success(
                data: ['keepalive_at' => now()->toIso8601String()],
                message: 'Keepalive recorded.',
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/sessions/{session}/token/refresh
    // Client requests a fresh Agora token when current one is about to expire.
    // =========================================================================

    public function refreshToken(Request $request, Session $session): JsonResponse
    {
        try {
            $tokenData = $this->sessionService->refreshToken(
                session: $session,
                user: $request->user(),
            );

            return $this->success(
                data: $tokenData,
                message: 'Token refreshed.',
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // GET /api/bookings/{booking}/session
    // Retrieve the session associated with a booking.
    // Convenience endpoint for the booking detail screen.
    // =========================================================================

    public function showByBooking(Request $request, \App\Models\Booking $booking): JsonResponse
    {
        $user = $request->user();

        $allowed = $user->role->value === 'admin'
            || $user->id === $booking->student_id
            || $user->id === $booking->tutor_id;

        if (! $allowed) {
            return $this->error('You do not have access to this session.', 403);
        }

        $session = $booking->session;

        if (! $session) {
            return $this->error('No session exists for this booking yet.', 404);
        }

        $session->load(['booking', 'agoraChannel']);

        return $this->success(new SessionResource($session));
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function authorizeParticipant(\App\Models\User $user, Session $session): void
    {
        $session->loadMissing('booking');

        $allowed = $user->role->value === 'admin'
            || $user->id === $session->booking->student_id
            || $user->id === $session->booking->tutor_id;

        if (! $allowed) {
            abort(403, 'You do not have access to this session.');
        }
    }

    private function success(mixed $data, string $message = 'OK', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    private function error(string $message, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => null,
        ], $status);
    }
}