<?php

namespace App\Notifications;

use App\Models\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Services\NotificationPreferenceService;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class SessionEndedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Session $session,
        private readonly string  $recipient,
        private readonly int     $durationSeconds,
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'session_ended');
    }

    public function toArray(object $notifiable): array
    {
        $minutes = (int) round($this->durationSeconds / 60);
        $escrow  = $this->session->booking?->escrowTransaction;

        return [
            'type'             => 'session_ended',
            'session_id'       => $this->session->id,
            'booking_id'       => $this->session->booking_id,
            'subject'          => $this->session->booking?->subject,
            'duration_minutes' => $minutes,
            'message'          => $this->recipient === 'tutor'
                ? "Session complete. R{$escrow?->net_to_tutor} has been added to your wallet."
                : "Your session has ended. Duration: {$minutes} minute(s). Please leave a review!",
            'net_earned' => $this->recipient === 'tutor'
                ? (float) ($escrow?->net_to_tutor ?? 0)
                : null,
        ];
    }
    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Session ended')
            ->view('emails.session-ended', [
                'message'         => $data['message'],
                'subject'         => $data['subject'],
                'durationMinutes' => $data['duration_minutes'],
                'netEarned'       => $data['net_earned'],
                'recipient'       => $this->recipient,
                'bookingId'       => $data['booking_id'],
            ]);
    }
    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('Session ended')
                    ->body($data['message'])
            )
            ->data(array_filter([
                'type'             => $data['type'],
                'session_id'       => (string) $data['session_id'],
                'booking_id'       => (string) $data['booking_id'],
                'duration_minutes' => (string) $data['duration_minutes'],
                'net_earned'       => $data['net_earned'] !== null
                    ? (string) $data['net_earned']
                    : null,
            ]));
    }
}