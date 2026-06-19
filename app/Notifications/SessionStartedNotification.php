<?php

namespace App\Notifications;

use App\Models\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Services\NotificationPreferenceService;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class SessionStartedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Session $session,
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'session_started');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'session_started',
            'session_id' => $this->session->id,
            'booking_id' => $this->session->booking_id,
            'subject'    => $this->session->booking?->subject,
            'message'    => 'Your session has started. Join now!',
        ];
    }
    
    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Your session is starting now')
            ->view('emails.session-started', [
                'message'   => $data['message'],
                'subject'   => $data['subject'],
                'sessionId' => $data['session_id'],
            ]);
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('Session starting now 🎓')
                    ->body($data['message'])
            )
            ->data([
                'type'       => $data['type'],
                'session_id' => (string) $data['session_id'],
                'booking_id' => (string) $data['booking_id'],
            ]);
    }
}