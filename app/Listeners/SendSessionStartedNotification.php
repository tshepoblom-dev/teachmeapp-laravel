<?php

namespace App\Listeners;

use App\Events\SessionStarted;
use App\Notifications\SessionStartedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendSessionStartedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch only after the wrapping DB transaction commits so the session
     * row has its 'in_progress' status persisted before the job runs.
     */
    public bool $afterCommit = true;

    public function handle(SessionStarted $event): void
    {
        $session = $event->session->loadMissing(['booking.student', 'booking.tutor']);
        $booking = $session->booking;

        try {
            // Notify the student that the tutor has started the session
            $booking->student->notify(
                new SessionStartedNotification($session)
            );

            Log::info('SessionStarted notification sent', [
                'session_id' => $session->id,
                'student_id' => $booking->student_id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send SessionStarted notification', [
                'session_id' => $session->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
