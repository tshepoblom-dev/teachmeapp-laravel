<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class AdminBroadcastNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $title,
        private readonly string $body,
        private readonly array  $channels, // explicit — bypasses user preferences
    ) {
        $this->onQueue('notifications');
    }

    /**
     * Admin-sent notifications use explicitly chosen channels,
     * bypassing per-user preferences entirely.
     */
    public function via(object $notifiable): array
    {
        return array_map(fn (string $channel) => match ($channel) {
            'fcm'  => \NotificationChannels\Fcm\FcmChannel::class,
            default => $channel,   // 'database', 'mail' pass through as-is
        }, $this->channels);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'admin_broadcast',
            'title'   => $this->title,
            'message' => $this->body,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->title)
            ->view('emails.admin-broadcast', [
                'title' => $this->title,
                'body'  => $this->body,
            ]);
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title($this->title)
                    ->body($this->body)
            )
            ->data(['type' => 'admin_broadcast']);
    }
}
