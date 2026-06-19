<?php

namespace App\Listeners;

use App\Events\BookingCancelled;
use App\Notifications\BookingCancelledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendBookingCancelledNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch only after the wrapping DB transaction commits so the booking
     * cancellation and any penalty records are persisted before the job runs.
     */
    public bool $afterCommit = true;

    public function handle(BookingCancelled $event): void
    {
        $booking     = $event->booking->load(['student', 'tutor']);
        $cancelledBy = $event->cancelledBy;

        try {
            // Notify the OTHER party (the one who didn't cancel)
            $notifyUser = $cancelledBy->id === $booking->student_id
                ? $booking->tutor
                : $booking->student;

            $notifyUser->notify(
                new BookingCancelledNotification(
                    booking: $booking,
                    cancelledBy: $cancelledBy,
                    penaltyApplied: $event->penaltyApplied,
                )
            );

            Log::info('BookingCancelled notification sent', [
                'booking_id'    => $booking->id,
                'notified_user' => $notifyUser->id,
                'cancelled_by'  => $cancelledBy->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send BookingCancelled notification', [
                'booking_id' => $booking->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
