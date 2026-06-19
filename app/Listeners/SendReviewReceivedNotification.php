<?php

namespace App\Listeners;

use App\Events\ReviewReceived;
use App\Notifications\ReviewReceivedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendReviewReceivedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch only after the wrapping DB transaction commits so the review
     * row is fully persisted before the notification job runs.
     */
    public bool $afterCommit = true;

    public function handle(ReviewReceived $event): void
    {
        $review = $event->review->loadMissing(['reviewer', 'reviewee']);

        try {
            // Notify the tutor (reviewee) that they received a review
            $review->reviewee->notify(
                new ReviewReceivedNotification($review)
            );

            Log::info('ReviewReceived notification sent', [
                'review_id'   => $review->id,
                'reviewee_id' => $review->reviewee_id,
                'rating'      => $review->rating,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send ReviewReceived notification', [
                'review_id' => $review->id,
                'error'     => $e->getMessage(),
            ]);

            // Do not rethrow — notification failure must never affect review flow
        }
    }
}
