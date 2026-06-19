<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class ReviewController extends Controller
{
    public function __construct(private readonly ReviewService $reviewService) {}

    // ─── Student: submit a review ─────────────────────────────────────────────

    /**
     * POST /student/bookings/{booking}/review
     */
    public function store(Request $request, Booking $booking): RedirectResponse
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
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ─── Public: reviews for a tutor profile ─────────────────────────────────

    /**
     * GET /tutors/{tutor}/reviews
     * Returns visible reviews as JSON (consumed by the booking/discover pages).
     */
    public function tutorReviews(Request $request, User $tutor): JsonResponse
    {
        abort_unless($tutor->role->value === 'tutor', 404);

        $reviews = Review::with('reviewer:id,name')
            ->where('reviewee_id', $tutor->id)
            ->where('is_visible', true)
            ->orderByDesc('reviewed_at')
            ->paginate(10)
            ->through(fn ($r) => [
                'id'          => $r->id,
                'rating'      => $r->rating,
                'comment'     => $r->comment,
                'tags'        => $r->tags ?? [],
                'reviewer'    => $r->reviewer?->name,
                'reviewed_at' => $r->reviewed_at?->toDateString(),
            ]);

        return response()->json($reviews);
    }
}