<?php

namespace App\Observers;

use App\Events\NotificationBroadcast;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Log;

/**
 * Observes the DatabaseNotification model and fires NotificationBroadcast
 * on every new row — so every notification class in the app automatically
 * gets real-time WebSocket delivery with zero changes to individual
 * notification classes.
 *
 * Registered in AppServiceProvider::boot().
 */
class NotificationObserver
{
    /**
     * Handle the DatabaseNotification "created" event.
     */
    public function created(DatabaseNotification $notification): void
    {
        try {
            NotificationBroadcast::dispatch($notification);
        } catch (\Throwable $e) {
            // Broadcast failure must never block the notification from persisting to DB
            Log::error('NotificationObserver: failed to dispatch broadcast', [
                'notification_id'   => $notification->id,
                'notification_type' => $notification->type,
                'notifiable_id'     => $notification->notifiable_id,
                'error'             => $e->getMessage(),
            ]);
        }
    }
}
