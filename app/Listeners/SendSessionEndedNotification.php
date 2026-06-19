<?php

namespace App\Listeners;

use App\Events\SessionEnded;
use App\Notifications\SessionEndedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendSessionEndedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch only after the wrapping DB transaction commits so the escrow
     * release record (net_to_tutor) is persisted before the notification job reads it.
     */
    public bool $afterCommit = true;

    public function handle(SessionEnded $event): void
    {
        // Eager-load escrowTransaction alongside student and tutor so the
        // tutor's net_earned message doesn't trigger extra lazy-load queries.
        $session = $event->session->loadMissing([
            'booking.student',
            'booking.tutor',
            'booking.escrowTransaction',
        ]);
        $booking = $session->booking;

        try {
            // Notify both parties the session has ended
            $booking->student->notify(
                new SessionEndedNotification(
                    session: $session,
                    recipient: 'student',
                    durationSeconds: $event->durationSeconds,
                )
            );

            $booking->tutor->notify(
                new SessionEndedNotification(
                    session: $session,
                    recipient: 'tutor',
                    durationSeconds: $event->durationSeconds,
                )
            );

            Log::info('SessionEnded notifications sent', [
                'session_id' => $session->id,
                'student_id' => $booking->student_id,
                'tutor_id'   => $booking->tutor_id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send SessionEnded notification', [
                'session_id' => $session->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
