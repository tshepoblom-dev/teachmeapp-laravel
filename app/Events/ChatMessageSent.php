<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Broadcast a chat message to both participants of a session.
 *
 * Fired by ChatController::store() immediately after saving the message.
 * Both Join.vue (student) and Show.vue (tutor) listen on:
 *
 *   Echo.private(`session.${sessionId}`).listen('.session.chat', handler)
 *
 * Uses ShouldBroadcastNow for instant delivery — chat must feel real-time.
 */
class ChatMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly ChatMessage $message,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("session.{$this->message->session_id}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'session.chat';
    }

    public function broadcastWith(): array
    {
        $sender = $this->message->relationLoaded('sender') ? $this->message->sender : null;

        return [
            'id'                => $this->message->id,
            'session_id'        => $this->message->session_id,
            'is_system_message' => (bool) $this->message->is_system_message,
            'sender'            => $sender ? [
                'id'     => $sender->id,
                'name'   => $sender->name,
                'role'   => $sender->role->value,
                'avatar' => $sender->profile_photo_url ?? null,
            ] : null,
            'message'     => $this->message->message,
            'attachments' => $this->message->attachments ?? [],
            'timestamps'  => [
                'sent_at'      => $this->message->created_at?->toIso8601String(),
                'delivered_at' => $this->message->delivered_at?->toIso8601String(),
                'read_at'      => $this->message->read_at?->toIso8601String(),
            ],
        ];
    }
}
