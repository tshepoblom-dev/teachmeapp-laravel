<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TutorBookingController extends Controller
{
    public function __construct(private readonly BookingService $bookingService) {}

    public function index(Request $request): Response
    {
        $status   = $request->query('status');
        $query    = Booking::with('student:id,name,email', 'session:id,booking_id,status')
            ->where('tutor_id', $request->user()->id)
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('scheduled_at');

        return Inertia::render('Tutor/Bookings/Index', [
            'bookings' => $query->paginate(15)->through(fn ($b) => $this->formatBooking($b)),
            'filter'   => $status,
            'statuses' => ['pending','accepted','in_progress','completed','declined','cancelled','disputed'],
        ]);
    }

    public function requests(Request $request): Response
    {
        $pending = Booking::with('student:id,name,email,profile_photo_path', 'student.profile')
            ->where('tutor_id', $request->user()->id)
            ->where('status', 'pending')
            ->orderBy('scheduled_at')
            ->get()
            ->map(fn ($b) => $this->formatBooking($b));

        return Inertia::render('Tutor/Bookings/Requests', [
            'requests' => $pending,
        ]);
    }

    public function show(Request $request, Booking $booking): Response
    {
        abort_unless($booking->tutor_id === $request->user()->id, 403);

        $booking->load([
            'student:id,name,email',
            'session',
            'escrowTransaction',
            'review',
        ]);

        return Inertia::render('Tutor/Bookings/Show', [
            'booking' => [
                'id'                   => $booking->id,
                'subject'              => $booking->subject,
                'description'          => $booking->description,
                'scheduled_at'         => $booking->scheduled_at->toIso8601String(),
                'duration_minutes'     => $booking->duration_minutes,
                'hourly_rate_snapshot' => (float) $booking->hourly_rate_snapshot,
                'total_amount'         => (float) $booking->total_amount,
                'status'               => $booking->status->value,
                'student'              => [
                    'id'   => $booking->student->id,
                    'name' => $booking->student->name,
                ],
                'session' => $booking->session ? [
                    'id'     => $booking->session->id,
                    'status' => $booking->session->status->value,
                ] : null,
                'escrow' => $booking->escrowTransaction ? [
                    'amount'     => (float) $booking->escrowTransaction->amount,
                    'status'     => $booking->escrowTransaction->status->value,
                    'net_to_tutor' => (float) $booking->escrowTransaction->net_to_tutor,
                ] : null,
                'review' => $booking->review ? [
                    'rating'  => $booking->review->rating,
                    'comment' => $booking->review->comment,
                ] : null,
            ],
        ]);
    }

    public function accept(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->tutor_id === $request->user()->id, 403);
        try {
            $this->bookingService->accept($booking, $request->user());
            return redirect()->route('tutor.bookings.show', $booking)
                ->with('success', 'Booking accepted. Escrow held.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function decline(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->tutor_id === $request->user()->id, 403);
        $request->validate(['reason' => 'nullable|string|max:500']);
        try {
            $this->bookingService->decline($booking, $request->user(), $request->reason);
            return redirect()->route('tutor.bookings.requests')
                ->with('success', 'Booking declined.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->tutor_id === $request->user()->id, 403);
        $request->validate(['reason' => 'nullable|string|max:500']);
        try {
            $this->bookingService->cancel($booking, $request->user(), $request->reason);
            return back()->with('success', 'Booking cancelled.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function formatBooking(Booking $b): array
    {
        return [
            'id'           => $b->id,
            'subject'      => $b->subject,
            'scheduled_at' => $b->scheduled_at->toIso8601String(),
            'duration'     => $b->duration_minutes,
            'total'        => (float) $b->total_amount,
            'status'       => $b->status->value,
            'student'      => $b->relationLoaded('student') ? [
                'id'   => $b->student->id,
                'name' => $b->student->name,
            ] : null,
            'session_id'   => $b->session?->id,
        ];
    }
}