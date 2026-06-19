<?php

namespace App\Events;

use App\Models\Session;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SessionEnded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Session  $session,
        public readonly User     $endedBy,
        public readonly int      $durationSeconds,
        public readonly ?string  $reason = null,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("session.{$this->session->id}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'session.ended';
    }

    public function broadcastWith(): array
    {
        return [
            'session_id'       => $this->session->id,
            'ended_at'         => $this->session->ended_at?->toIso8601String(),
            'duration_seconds' => $this->durationSeconds,
            'ended_by'         => [
                'id'   => $this->endedBy->id,
                'name' => $this->endedBy->name,
            ],
            'reason' => $this->reason,
        ];
    }
}
