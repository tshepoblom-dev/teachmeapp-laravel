<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Http\Requests\AdminDisputeRequest;
use App\Http\Requests\CancelBookingRequest;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Throwable;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService,
    ) {}

    // =========================================================================
    // GET /api/bookings
    // List bookings for the authenticated user.
    // Students see their own bookings. Tutors see bookings assigned to them.
    // Admins see all bookings with optional filters.
    // =========================================================================

    public function index(Request $request): AnonymousResourceCollection
    {
        $user  = $request->user();
        $query = Booking::query()
            ->with(['student', 'tutor', 'session', 'escrowTransaction', 'paymentMethod']);

        if ($user->role->value === 'admin') {
            // Admin filters
            if ($request->filled('student_id')) {
                $query->where('student_id', $request->integer('student_id'));
            }
            if ($request->filled('tutor_id')) {
                $query->where('tutor_id', $request->integer('tutor_id'));
            }
            if ($request->filled('status')) {
                $query->where('status', $request->string('status'));
            }
            if ($request->filled('from')) {
                $query->where('scheduled_at', '>=', Carbon::parse($request->string('from')));
            }
            if ($request->filled('to')) {
                $query->where('scheduled_at', '<=', Carbon::parse($request->string('to')));
            }
        } elseif ($user->role->value === 'tutor') {
            $query->where('tutor_id', $user->id);

            if ($request->filled('status')) {
                $query->where('status', $request->string('status'));
            }
        } else {
            // Student
            $query->where('student_id', $user->id);

            if ($request->filled('status')) {
                $query->where('status', $request->string('status'));
            }
        }

        $bookings = $query
            ->orderByDesc('scheduled_at')
            ->paginate($request->integer('per_page', 15));

        return BookingResource::collection($bookings);
    }

    // =========================================================================
    // POST /api/bookings
    // Student creates a new booking request.
    // =========================================================================

    public function store(CreateBookingRequest $request): JsonResponse
    {
        try {
            $booking = $this->bookingService->create(
                student: $request->user(),
                data: $request->validated(),
            );

            return $this->success(
                data: new BookingResource($booking->load(['student', 'tutor', 'paymentMethod'])),
                message: 'Booking request submitted. Awaiting tutor confirmation.',
                status: 201,
            );
        } catch (Throwable $e) {
            Log::warning('Booking creation failed', [
                'user_id' => $request->user()->id,
                'error'   => $e->getMessage(),
            ]);

            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // GET /api/bookings/{booking}
    // View a single booking. Only parties involved or admin.
    // =========================================================================

    public function show(Request $request, Booking $booking): JsonResponse
    {
        $this->authorizeAccess($request->user(), $booking);

        $booking->load(['student', 'tutor', 'session', 'escrowTransaction', 'paymentMethod', 'review']);

        return $this->success(new BookingResource($booking));
    }

    // =========================================================================
    // POST /api/bookings/{booking}/accept
    // Tutor accepts a pending booking → escrow held.
    // =========================================================================

    public function accept(Request $request, Booking $booking): JsonResponse
    {
        if ($request->user()->role->value !== 'tutor') {
            return $this->error('Only tutors can accept bookings.', 403);
        }

        try {
            $booking = $this->bookingService->accept(
                booking: $booking,
                tutor: $request->user(),
            );

            return $this->success(
                data: new BookingResource($booking->load(['student', 'tutor', 'escrowTransaction'])),
                message: 'Booking accepted. Session funds are now held in escrow.',
            );
        } catch (Throwable $e) {
            Log::warning('Booking accept failed', [
                'booking_id' => $booking->id,
                'tutor_id'   => $request->user()->id,
                'error'      => $e->getMessage(),
            ]);

            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/bookings/{booking}/decline
    // Tutor declines a pending booking.
    // =========================================================================

    public function decline(Request $request, Booking $booking): JsonResponse
    {
        if ($request->user()->role->value !== 'tutor') {
            return $this->error('Only tutors can decline bookings.', 403);
        }

        $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $booking = $this->bookingService->decline(
                booking: $booking,
                tutor: $request->user(),
                reason: $request->string('reason')->value() ?: null,
            );

            return $this->success(
                data: new BookingResource($booking),
                message: 'Booking declined.',
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/bookings/{booking}/cancel
    // Student, tutor, or admin cancels a booking.
    // Penalty logic is handled inside BookingService.
    // =========================================================================

    public function cancel(CancelBookingRequest $request, Booking $booking): JsonResponse
    {
        try {
            $booking = $this->bookingService->cancel(
                booking: $booking,
                cancelledBy: $request->user(),
                reason: $request->validated('reason'),
            );

            return $this->success(
                data: new BookingResource($booking->load(['escrowTransaction'])),
                message: 'Booking cancelled successfully.',
            );
        } catch (Throwable $e) {
            Log::warning('Booking cancel failed', [
                'booking_id' => $booking->id,
                'user_id'    => $request->user()->id,
                'error'      => $e->getMessage(),
            ]);

            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/admin/bookings/{booking}/dispute
    // Admin resolves a disputed booking — either release to tutor or refund student.
    // =========================================================================

    public function resolveDispute(AdminDisputeRequest $request, Booking $booking): JsonResponse
    {
        if ($booking->status !== BookingStatus::Disputed) {
            return $this->error('This booking is not in a disputed state.', 422);
        }

        try {
            $this->bookingService->resolveDispute(
                $booking,
                $request->user(),
                $request->validated('action'),
                $request->validated('reason'),
            );
            return $this->success(
                data: new BookingResource($booking->fresh()->load(['escrowTransaction'])),
                message: $request->validated('action') === 'release'
                    ? 'Escrow released to tutor.'
                    : 'Escrow refunded to student.',
            );
        } catch (Throwable $e) {
            Log::error('Dispute resolution failed', [
                'booking_id' => $booking->id,
                'admin_id'   => $request->user()->id,
                'error'      => $e->getMessage(),
            ]);

            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // GET /api/tutors/{tutor}/availability
    // Returns a tutor's booked slots for a date range (public — used on booking UI).
    // =========================================================================

    public function tutorAvailability(Request $request, int $tutorId): JsonResponse
    {
        $request->validate([
            'from' => ['required', 'date'],
            'to'   => ['required', 'date', 'after_or_equal:from'],
        ]);

        $slots = $this->bookingService->getTutorBookedSlots(
            tutorId: $tutorId,
            from: Carbon::parse($request->string('from'))->startOfDay(),
            to: Carbon::parse($request->string('to'))->endOfDay(),
        );

        return $this->success([
            'tutor_id'     => $tutorId,
            'from'         => $request->string('from'),
            'to'           => $request->string('to'),
            'booked_slots' => $slots->map(fn ($b) => [
                'id'               => $b->id,
                'starts_at'        => Carbon::parse($b->scheduled_at)->toIso8601String(),
                'ends_at'          => Carbon::parse($b->scheduled_at)
                                        ->addMinutes($b->duration_minutes)
                                        ->toIso8601String(),
                'duration_minutes' => $b->duration_minutes,
                'status'           => $b->status->value,
            ]),
        ]);
    }

    // =========================================================================
    // GET /api/tutor/bookings/requests
    // Tutor-specific: pending booking requests awaiting their response.
    // =========================================================================

    public function pendingRequests(Request $request): AnonymousResourceCollection
    {
        if ($request->user()->role->value !== 'tutor') {
            abort(403, 'Only tutors can view booking requests.');
        }

        $bookings = Booking::where('tutor_id', $request->user()->id)
            ->where('status', BookingStatus::Pending)
            ->with(['student', 'paymentMethod'])
            ->orderBy('scheduled_at')
            ->paginate($request->integer('per_page', 15));

        return BookingResource::collection($bookings);
    }

    // =========================================================================
    // GET /api/bookings/upcoming
    // Shared endpoint: returns the next N upcoming confirmed bookings for the user.
    // =========================================================================

    public function upcoming(Request $request): AnonymousResourceCollection
    {
        $user  = $request->user();
        $limit = $request->integer('limit', 5);

        $query = Booking::query()
            ->whereIn('status', [BookingStatus::Accepted, BookingStatus::InProgress])
            ->where('scheduled_at', '>=', now())
            ->with(['student', 'tutor', 'session'])
            ->orderBy('scheduled_at')
            ->limit($limit);

        if ($user->role->value === 'tutor') {
            $query->where('tutor_id', $user->id);
        } elseif ($user->role->value === 'student') {
            $query->where('student_id', $user->id);
        }
        // Admin gets all upcoming regardless of role

        return BookingResource::collection($query->get());
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function authorizeAccess(\App\Models\User $user, Booking $booking): void
    {
        $allowed = $user->role->value === 'admin'
            || $user->id === $booking->student_id
            || $user->id === $booking->tutor_id;

        if (! $allowed) {
            abort(403, 'You do not have access to this booking.');
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