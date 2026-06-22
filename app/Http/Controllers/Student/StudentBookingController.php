<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PaymentMethod;
use App\Models\Session;
use App\Models\User;
use App\Services\BookingService;
use App\Services\SessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\ReviewService;

class StudentBookingController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService,
        private readonly SessionService $sessionService,
        private readonly ReviewService  $reviewService,
    ) {}

    public function index(Request $request): Response
    {
        $status = $request->query('status');

        $bookings = Booking::with('tutor:id,name', 'session:id,booking_id,status', 'review')
            ->where('student_id', $request->user()->id)
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('scheduled_at')
            ->paginate(15)
            ->through(fn ($b) => [
                'id'           => $b->id,
                'subject'      => $b->subject,
                'tutor_name'   => $b->tutor->name,
                'scheduled_at' => $b->scheduled_at->toIso8601String(),
                'duration'     => $b->duration_minutes,
                'total'        => (float) $b->total_amount,
                'status'       => $b->status->value,
                'session_id'   => $b->session?->id,
                'has_review'   => (bool) $b->review,
            ]);

        return Inertia::render('Student/Bookings/Index', [
            'bookings' => $bookings,
            'filter'   => $status,
            'statuses' => ['pending', 'accepted', 'in_progress', 'completed', 'cancelled', 'disputed'],
        ]);
    }

    public function create(Request $request, User $user): Response
    {
        abort_unless($user->role->value === 'tutor', 404);
        $user->load('profile.tutorTier', 'availabilitySlots');

        $student = $request->user()->load('wallet');
        $methods = PaymentMethod::where('is_active', true)
            ->orderBy('display_order')
            ->get()
            ->map(fn ($m) => ['id' => $m->id, 'code' => $m->code, 'name' => $m->name]);

        $durations = \App\Models\PlatformSetting::getValue('sessions', 'duration_options', [60, 90, 120, 180]);
        if (is_string($durations)) {
            $durations = json_decode($durations, true);
        }

        // Buffer minutes used by the calendar's conflict-detection logic —
        // must match assertTutorAvailableAt() in BookingService exactly.
        $bufferMins = (int) \App\Models\PlatformSetting::getValue(
            'sessions', 'session_buffer_minutes', 15
        );

        // Forward enough of the tutor's future bookings for the calendar to
        // shade out conflicting slots client-side. Only non-terminal statuses
        // matter; we look 3 months ahead to cover any visible calendar month.
        //
        // The date array format [year, jsMonth, day] matches JavaScript's
        // Date constructor convention (month is 0-based).
        $existingBookings = Booking::where('tutor_id', $user->id)
            ->whereIn('status', ['pending', 'accepted', 'in_progress'])
            ->whereBetween('scheduled_at', [now(), now()->addMonths(3)])
            ->get(['scheduled_at', 'duration_minutes'])
            ->map(function ($b) {
                // Convert to app-local time (SAST) so the frontend calendar's
                // conflict-detection compares apples-to-apples with the tutor's
                // availability slots, which are also stored in local time.
                $local = $b->scheduled_at->copy()->setTimezone(config('app.local_timezone'));
                return [
                    'date'     => [
                        $local->year,
                        $local->month - 1,   // JS months are 0-based
                        $local->day,
                    ],
                    'startH'   => (int) $local->format('G'),
                    'startM'   => (int) $local->format('i'),
                    'duration' => $b->duration_minutes,
                ];
            });

        return Inertia::render('Student/Bookings/Create', [
            'tutor' => [
                'id'          => $user->id,
                'name'        => $user->name,
                'subjects'    => $user->profile?->subjects ?? [],
                'hourly_rate' => (float) ($user->profile?->hourly_rate ?? 0),
                'tier'        => $user->profile?->tutorTier?->name,
                'tier_colour' => $user->profile?->tutorTier?->theme_colour_primary,
            ],
            // Availability slots shaped for the Vue calendar:
            //   day   → backend day_of_week (0 = Monday … 6 = Sunday)
            //   start → "HH:MM"
            //   end   → "HH:MM"
            'availability' => $user->availabilitySlots
                ->where('is_active', true)
                ->values()
                ->map(fn ($s) => [
                    'day'   => $s->day_of_week,
                    'start' => substr($s->start_time, 0, 5),
                    'end'   => substr($s->end_time,   0, 5),
                ]),
            'existing_bookings' => $existingBookings,
            'buffer_minutes'    => $bufferMins,
            'wallet_balance'    => (float) ($student->wallet?->balance ?? 0),
            'payment_methods'   => $methods,
            'duration_options'  => $durations,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tutor_id'          => ['required', 'exists:users,id'],
            'subject'           => ['required', 'string', 'max:100'],
            'description'       => ['nullable', 'string', 'max:1000'],
            'scheduled_at'      => ['required', 'date', 'after:now'],
            'duration_minutes'  => ['required', 'integer'],
            'payment_method_id' => ['nullable', 'exists:payment_methods,id'],
        ]);

        try {
            $booking = $this->bookingService->create($request->user(), $data);
            return redirect()->route('student.bookings.show', $booking)
                ->with('success', 'Booking request sent! Waiting for tutor confirmation.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Request $request, Booking $booking): Response
    {
        abort_unless($booking->student_id === $request->user()->id, 403);
        $booking->load('tutor:id,name', 'session', 'escrowTransaction', 'review', 'invoice');

        return Inertia::render('Student/Bookings/Show', [
            'booking' => [
                'id'                   => $booking->id,
                'subject'              => $booking->subject,
                'description'          => $booking->description,
                'scheduled_at'         => $booking->scheduled_at->toIso8601String(),
                'duration_minutes'     => $booking->duration_minutes,
                'hourly_rate_snapshot' => (float) $booking->hourly_rate_snapshot,
                'total_amount'         => (float) $booking->total_amount,
                'status'               => $booking->status->value,
                'tutor'                => ['id' => $booking->tutor->id, 'name' => $booking->tutor->name],
                'session'              => $booking->session ? [
                    'id'     => $booking->session->id,
                    'status' => $booking->session->status->value,
                ] : null,
                'escrow'               => $booking->escrowTransaction ? [
                    'amount' => (float) $booking->escrowTransaction->amount,
                    'status' => $booking->escrowTransaction->status->value,
                ] : null,
                'review'               => $booking->review ? [
                    'rating'  => $booking->review->rating,
                    'comment' => $booking->review->comment,
                ] : null,
                'can_review' => $booking->status->value === 'completed' && ! $booking->review,
            ],
        ]);
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->student_id === $request->user()->id, 403);
        $request->validate(['reason' => 'nullable|string|max:500']);
        try {
            $this->bookingService->cancel($booking, $request->user(), $request->reason);
            return back()->with('success', 'Booking cancelled.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function review(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->student_id === $request->user()->id, 403);

        $data = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'tags'    => ['nullable', 'array', 'max:8'],
            'tags.*'  => ['string', 'max:50'],
        ]);

        try {
            $this->reviewService->submit($request->user(), $booking, $data);
            return back()->with('success', 'Review submitted — thank you!');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function joinSession(Request $request, Session $session): Response|RedirectResponse
    {
        $session->load('booking.tutor:id,name');
        abort_unless($session->booking->student_id === $request->user()->id, 403);

        // Guard: block access when the scheduled window has passed and nobody ever joined.
        if ($session->isExpired()) {
            return redirect()
                ->route('student.bookings.show', $session->booking->id)
                ->with('error', 'This session has expired. The scheduled time and duration have passed without the session starting.');
        }

        // Guard: don't call join() if session is already ended/abandoned
        $tokenData = null;
        if ($session->status->isJoinable()) {
            try {
                $tokenData = $this->sessionService->join($session, $request->user());
            } catch (\Throwable $e) {
                // Too early or ended — pass null; Vue handles gracefully
            }
        }

        return Inertia::render('Student/Sessions/Join', [
            'session' => [
                'id'           => $session->id,
                'status'       => $session->status->value,
                'status_label' => $session->status->label(),
                'channel_name' => $session->agora_channel_name,
                'agora_token'  => $tokenData['token'] ?? null,
                'agora_uid'    => $tokenData['uid']   ?? null,
                'started_at'   => $session->started_at?->toIso8601String(),
                'ended_at'     => $session->ended_at?->toIso8601String(),
                'booking'      => [
                    'id'           => $session->booking->id,
                    'subject'      => $session->booking->subject,
                    'duration'     => $session->booking->duration_minutes,
                    'tutor_id'     => $session->booking->tutor_id,
                    'tutor_name'   => $session->booking->tutor->name,
                    'scheduled_at' => $session->booking->scheduled_at->toIso8601String(),
                ],
            ],
            'agora_app_id' => config('agora.app_id'),
            'role'         => 'student',
        ]);
    }

    /**
     * Student-side session end.
     * Students can leave an active or in-progress session early.
     */
    public function endSession(Request $request, Session $session): \Illuminate\Http\RedirectResponse
    {
        $session->load('booking');
        abort_unless($session->booking->student_id === $request->user()->id, 403);

        $request->validate(['reason' => 'nullable|string|max:500']);

        try {
            $this->sessionService->end($session, $request->user(), $request->reason);
            return redirect()
                ->route('student.bookings.show', $session->booking_id)
                ->with('success', 'Session ended.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
