<?php

namespace App\Listeners;

use App\Events\BookingAccepted;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BookingAcceptedNotification;

class SendBookingAcceptedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch only after the wrapping DB transaction commits so the booking
     * row has its final 'accepted' status before the notification job runs.
     */
    public bool $afterCommit = true;

    public function handle(BookingAccepted $event): void
    {
        $booking = $event->booking->load(['student', 'tutor']);

        try {
            // Notify student their booking was accepted
            $booking->student->notify(
                new BookingAcceptedNotification($booking, recipient: 'student')
            );

            Log::info('BookingAccepted notification sent', [
                'booking_id' => $booking->id,
                'student_id' => $booking->student_id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send BookingAccepted notification', [
                'booking_id' => $booking->id,
                'error'      => $e->getMessage(),
            ]);

            // Do not rethrow — notification failure must never affect booking flow
        }
    }
}
