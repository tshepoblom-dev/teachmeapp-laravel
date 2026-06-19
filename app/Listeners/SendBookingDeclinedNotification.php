<?php

namespace App\Listeners;

use App\Events\BookingDeclined;
use App\Notifications\BookingDeclinedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendBookingDeclinedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch only after the wrapping DB transaction commits so the booking
     * cancellation and any penalty records are persisted before the job runs.
     */
    public bool $afterCommit = true;

    public function handle(BookingDeclined $event): void
    {
        $booking     = $event->booking->load(['student', 'tutor']);
        $declinedBy = $event->declinedBy;

        try {
            // Notify the OTHER party (the one who didn't cancel)
            $notifyUser = $declinedBy->id === $booking->student_id
                ? $booking->tutor
                : $booking->student;

            $notifyUser->notify(
                new BookingDeclinedNotification(
                    booking: $booking,
                    declinedBy: $declinedBy,
                    penaltyApplied: $event->penaltyApplied,
                )
            );

            Log::info('BookingDeclined notification sent', [
                'booking_id'    => $booking->id,
                'notified_user' => $notifyUser->id,
                'declined_by'  => $declinedBy->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send BookingDeclined notification', [
                'booking_id' => $booking->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
