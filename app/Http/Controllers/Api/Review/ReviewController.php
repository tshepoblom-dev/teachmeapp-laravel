<?php

namespace App\Http\Controllers\Api\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\SubmitReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use App\Services\ReviewService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class ReviewController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly ReviewService $reviewService) {}

    // ── POST /api/bookings/{booking}/review ───────────────────────────────────

    public function store(SubmitReviewRequest $request, Booking $booking): JsonResponse
    {
        abort_unless($booking->student_id === $request->user()->id, 403);

        try {
            $review = $this->reviewService->submit($request->user(), $booking, $request->validated());
        } catch (RuntimeException $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(new ReviewResource($review), 'Review submitted — thank you!', 201);
    }

    // ── GET /api/tutors/{tutor}/reviews ───────────────────────────────────────

    public function tutorReviews(Request $request, User $tutor): JsonResponse
    {
        abort_unless($tutor->role->value === 'tutor', 404);

        $reviews = Review::with('reviewer:id,name')
            ->where('reviewee_id', $tutor->id)
            ->where('is_visible', true)
            ->orderByDesc('reviewed_at')
            ->paginate(10);

        return $this->success(ReviewResource::collection($reviews)->response()->getData(true));
    }
}
