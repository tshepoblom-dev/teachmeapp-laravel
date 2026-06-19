<?php

namespace App\Services;

use App\Events\ReviewReceived;
use App\Models\AuditLog;
use App\Models\Booking;
use App\Models\Profile;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * ReviewService — single source of truth for post-session reviews.
 *
 * Responsibilities:
 *  - Submit a review (student → tutor only, one per booking)
 *  - Recalculate and cache average_rating + total_reviews on the tutor Profile
 *  - Admin moderation: hide, restore, delete
 */
class ReviewService
{
    // ─── Submit ───────────────────────────────────────────────────────────────

    /**
     * Submit a review for a completed booking.
     *
     * Rules enforced:
     *  - Booking must be completed
     *  - Reviewer must be the student on the booking
     *  - One review per booking (idempotency guard)
     *
     * @param  array{rating: int, comment?: string|null, tags?: array}  $data
     */
    public function submit(User $reviewer, Booking $booking, array $data): Review
    {
        if ($booking->student_id !== $reviewer->id) {
            throw new RuntimeException('Only the student on this booking can leave a review.');
        }

        if ($booking->status->value !== 'completed') {
            throw new RuntimeException('Reviews can only be submitted for completed sessions.');
        }

        if (Review::where('booking_id', $booking->id)->exists()) {
            throw new RuntimeException('A review has already been submitted for this booking.');
        }

        $rating = (int) $data['rating'];
        if ($rating < 1 || $rating > 5) {
            throw new RuntimeException('Rating must be between 1 and 5.');
        }

        return DB::transaction(function () use ($reviewer, $booking, $data, $rating) {
            $review = Review::create([
                'booking_id'  => $booking->id,
                'reviewer_id' => $reviewer->id,
                'reviewee_id' => $booking->tutor_id,
                'rating'      => $rating,
                'comment'     => $data['comment'] ?? null,
                'tags'        => $data['tags']    ?? [],
                'is_visible'  => true,
                'reviewed_at' => now(),
            ]);

            $this->recalculateRating($booking->tutor_id);

            ReviewReceived::dispatch($review);

            Log::info('Review submitted', [
                'review_id'  => $review->id,
                'booking_id' => $booking->id,
                'rating'     => $rating,
            ]);

            return $review;
        });
    }

    // ─── Rating recalculation ─────────────────────────────────────────────────

    /**
     * Recompute and persist average_rating + total_reviews on the tutor's Profile.
     * Uses only visible reviews for the public average.
     */
    public function recalculateRating(int $tutorId): void
    {
        $avg   = Review::where('reviewee_id', $tutorId)->where('is_visible', true)->avg('rating') ?? 0;
        $count = Review::where('reviewee_id', $tutorId)->where('is_visible', true)->count();

        Profile::where('user_id', $tutorId)->update([
            'average_rating' => round((float) $avg, 2),
            'total_reviews'  => $count,
        ]);
    }

    // ─── Admin moderation ─────────────────────────────────────────────────────

    /**
     * Hide a review from public view.
     * Triggers rating recalculation so hidden reviews don't skew the average.
     */
    public function hide(Review $review, User $admin): Review
    {
        if (! $review->is_visible) {
            throw new RuntimeException('Review is already hidden.');
        }

        $review->update(['is_visible' => false]);
        $this->recalculateRating($review->reviewee_id);

        AuditLog::create([
            'user_id'     => $admin->id,
            'action'      => 'review_hidden',
            'target_type' => 'review',
            'target_id'   => $review->id,
            'old_values'  => ['is_visible' => true],
            'new_values'  => ['is_visible' => false],
        ]);

        Log::info('ReviewService: review hidden', [
            'review_id' => $review->id,
            'admin_id'  => $admin->id,
        ]);

        return $review->fresh();
    }

    /**
     * Restore a previously hidden review.
     */
    public function restore(Review $review, User $admin): Review
    {
        if ($review->is_visible) {
            throw new RuntimeException('Review is already visible.');
        }

        $review->update(['is_visible' => true]);
        $this->recalculateRating($review->reviewee_id);

        AuditLog::create([
            'user_id'     => $admin->id,
            'action'      => 'review_restored',
            'target_type' => 'review',
            'target_id'   => $review->id,
            'old_values'  => ['is_visible' => false],
            'new_values'  => ['is_visible' => true],
        ]);

        Log::info('ReviewService: review restored', [
            'review_id' => $review->id,
            'admin_id'  => $admin->id,
        ]);

        return $review->fresh();
    }

    /**
     * Permanently delete a review.
     * Use sparingly — prefer hide() for audit trail preservation.
     */
    public function delete(Review $review, User $admin): void
    {
        $tutorId = $review->reviewee_id;

        AuditLog::create([
            'user_id'     => $admin->id,
            'action'      => 'review_deleted',
            'target_type' => 'review',
            'target_id'   => $review->id,
            'old_values'  => [
                'rating'     => $review->rating,
                'comment'    => $review->comment,
                'is_visible' => $review->is_visible,
            ],
        ]);

        Log::info('ReviewService: review deleted', [
            'review_id' => $review->id,
            'admin_id'  => $admin->id,
            'tutor_id'  => $tutorId,
        ]);

        $review->delete();
        $this->recalculateRating($tutorId);
    }
}