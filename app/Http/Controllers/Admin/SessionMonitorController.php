<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Services\SessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SessionMonitorController extends Controller
{
    public function __construct(
        private readonly SessionService $sessionService,
    ) {}

    public function index(Request $request): Response
    {
        $sessions = Session::with(['booking.student:id,name', 'booking.tutor:id,name', 'agoraChannel'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20)
            ->withQueryString()
            ->through(fn ($s) => [
                'id'           => $s->id,
                'status'       => $s->status->value,
                'booking_id'   => $s->booking_id,
                'channel_name' => $s->agora_channel_name,
                'started_at'   => $s->started_at?->toIso8601String(),
                'ended_at'     => $s->ended_at?->toIso8601String(),
                'duration_seconds' => $s->agoraChannel?->total_duration_seconds,
                'last_keepalive'   => $s->agoraChannel?->last_keepalive_at?->diffForHumans(),
                'student'      => $s->booking?->student?->name,
                'tutor'        => $s->booking?->tutor?->name,
                'recording_url'=> $s->recording_url,
            ]);

        $activeSessions = Session::where('status', 'active')->count();

        return Inertia::render('Admin/Sessions/Index', [
            'sessions'       => $sessions,
            'activeSessions' => $activeSessions,
            'filters'        => $request->only(['status']),
            'pendingKyc'     => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function forceEnd(Request $request, Session $session): RedirectResponse
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:500'],
        ]);

        try {
            $this->sessionService->end(
                session: $session,
                endedBy: $request->user(),
                reason: "Admin forced end: {$request->reason}",
            );

            return back()->with('success', 'Session ended by admin.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}