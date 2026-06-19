<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Queue\SerializesModels;

/**
 * Fired by NotificationObserver whenever a DatabaseNotification row is created.
 *
 * FIX: broadcastWith() now flattens `data.type` and `data.message` to the top
 * level so the JS composable (useRealTimeNotifications) can read them directly
 * from the payload without digging into the nested `data` object.
 */
class NotificationBroadcast implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly DatabaseNotification $notification
    ) {}

    public function onQueue(): string { return 'notifications'; }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('App.Models.User.' . $this->notification->notifiable_id);
    }

    public function broadcastAs(): string
    {
        return 'notification.new';
    }

    /**
     * Data sent to the client.
     *
     * `type` and `message` are promoted to the top level so the JS composable
     * can use payload.type and payload.message directly without reading
     * payload.data.type — which was the previous silent failure.
     */
    public function broadcastWith(): array
    {
        $data = $this->notification->data ?? [];

        return [
            'id'         => $this->notification->id,
            // Use the friendly key stored in data (e.g. 'booking_accepted')
            // rather than the PHP class name stored in the `type` DB column.
            'type'       => $data['type']    ?? $this->notification->type,
            'message'    => $data['message'] ?? '',
            'data'       => $data,
            'created_at' => $this->notification->created_at?->toISOString(),
            'read_at'    => $this->notification->read_at?->toISOString(),
        ];
    }
}
