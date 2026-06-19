<?php

namespace App\Events;

use App\Models\Session;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Broadcast whenever a session changes status.
 *
 * Both the tutor's and student's session pages listen on:
 *   Echo.private(`session.${sessionId}`).listen('.session.status', handler)
 *
 * Uses ShouldBroadcastNow for instant delivery (no queue delay).
 */
class SessionStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Session  $session,
        public readonly string   $oldStatus,
        public readonly string   $newStatus,
        public readonly ?User    $changedBy = null,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("session.{$this->session->id}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'session.status';
    }

    public function broadcastWith(): array
    {
        return [
            'session_id'  => $this->session->id,
            'old_status'  => $this->oldStatus,
            'new_status'  => $this->newStatus,
            'started_at'  => $this->session->started_at?->toIso8601String(),
            'ended_at'    => $this->session->ended_at?->toIso8601String(),
            'changed_by'  => $this->changedBy ? [
                'id'   => $this->changedBy->id,
                'name' => $this->changedBy->name,
            ] : null,
            'timestamp'   => now()->toIso8601String(),
        ];
    }
}
