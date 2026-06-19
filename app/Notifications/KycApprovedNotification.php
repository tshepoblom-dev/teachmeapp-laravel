<?php

namespace App\Notifications;

use App\Models\KycApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Services\NotificationPreferenceService;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class KycApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly KycApplication $application,
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'kyc_approved');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'           => 'kyc_approved',
            'application_id' => $this->application->id,
            'message'        => 'Your identity verification has been approved. You can now accept bookings.',
        ];
    }
    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('KYC approved — you\'re ready to teach')
            ->view('emails.kyc-approved', [
                'message' => $data['message'],
            ]);
    }
    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('KYC approved 🎉')
                    ->body($data['message'])
            )
            ->data([
                'type'           => $data['type'],
                'application_id' => (string) $data['application_id'],
            ]);
    }
}