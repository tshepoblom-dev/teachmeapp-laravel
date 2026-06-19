<?php

namespace App\Listeners;

use App\Events\SessionEnded;
use App\Events\SessionStarted;
use App\Events\ChatMessageSent;
use App\Models\ChatMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class WriteSessionSystemMessages implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'default';

    // -------------------------------------------------------------------------
    // SessionStarted → drop a "Session started" marker in chat
    // -------------------------------------------------------------------------

    public function handleSessionStarted(SessionStarted $event): void
    {
        $session = $event->session->loadMissing('booking.tutor');

        try {
            $message = ChatMessage::create([
                'session_id'        => $session->id,
                'sender_id'         => null,
                'message'           => "Session started by {$session->booking->tutor->name}.",
                'attachments'       => null,
                'is_system_message' => true,
                'delivered_at'      => now(),
            ]);

            ChatMessageSent::dispatch($message);
        } catch (\Throwable $e) {
            Log::error('Failed to write SessionStarted system message', [
                'session_id' => $session->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }

    // -------------------------------------------------------------------------
    // SessionEnded → drop a "Session ended" marker with duration
    // -------------------------------------------------------------------------

    public function handleSessionEnded(SessionEnded $event): void
    {
        $session  = $event->session;
        $minutes  = (int) round($event->durationSeconds / 60);
        $endedBy  = $event->endedBy->name;
        $reason   = $event->reason
            ? " Reason: {$event->reason}"
            : '';

        try {
            $message = ChatMessage::create([
                'session_id'        => $session->id,
                'sender_id'         => null,
                'message'           => "Session ended by {$endedBy}. Duration: {$minutes} minute(s).{$reason}",
                'attachments'       => null,
                'is_system_message' => true,
                'delivered_at'      => now(),
            ]);

            ChatMessageSent::dispatch($message);
        } catch (\Throwable $e) {
            Log::error('Failed to write SessionEnded system message', [
                'session_id' => $session->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }

    // -------------------------------------------------------------------------
    // Subscribe — maps both events to handlers on this single class
    // -------------------------------------------------------------------------

    public function subscribe(\Illuminate\Events\Dispatcher $events): array
    {
        return [
            SessionStarted::class => 'handleSessionStarted',
            SessionEnded::class   => 'handleSessionEnded',
        ];
    }
}