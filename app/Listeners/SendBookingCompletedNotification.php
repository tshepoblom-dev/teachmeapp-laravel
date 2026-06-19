<?php

namespace App\Listeners;

use App\Events\BookingCompleted;
use App\Notifications\BookingCompletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendBookingCompletedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch only after the wrapping DB transaction commits so that the
     * escrow record (net_to_tutor) is visible when the queued job reads it.
     */
    public bool $afterCommit = true;

    public function handle(BookingCompleted $event): void
    {
        $booking = $event->booking->load(['student', 'tutor', 'escrowTransaction']);

        try {
            // Notify student — prompt them to leave a review
            $booking->student->notify(
                new BookingCompletedNotification($booking, recipient: 'student')
            );

            // Notify tutor — confirm earnings were released
            $booking->tutor->notify(
                new BookingCompletedNotification($booking, recipient: 'tutor')
            );

            Log::info('BookingCompleted notifications sent', [
                'booking_id' => $booking->id,
                'student_id' => $booking->student_id,
                'tutor_id'   => $booking->tutor_id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send BookingCompleted notification', [
                'booking_id' => $booking->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
