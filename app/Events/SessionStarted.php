<?php

namespace App\Events;

use App\Models\Session;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SessionStarted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Session $session,
        public readonly User    $startedBy,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("session.{$this->session->id}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'session.started';
    }

    public function broadcastWith(): array
    {
        return [
            'session_id' => $this->session->id,
            'started_at' => $this->session->started_at?->toIso8601String(),
            'started_by' => [
                'id'   => $this->startedBy->id,
                'name' => $this->startedBy->name,
            ],
        ];
    }
}
