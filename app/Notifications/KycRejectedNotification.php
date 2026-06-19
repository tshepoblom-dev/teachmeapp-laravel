<?php

namespace App\Notifications;

use App\Models\KycApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Services\NotificationPreferenceService;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class KycRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly KycApplication $application,
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'kyc_rejected');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'             => 'kyc_rejected',
            'application_id'   => $this->application->id,
            'rejection_reason' => $this->application->rejection_reason,
            'message'          => 'Your identity verification was not approved. ' .
                'Reason: ' . $this->application->rejection_reason,
        ];
    }
    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('KYC application update')
            ->view('emails.kyc-rejected', [
                'message'         => $data['message'],
                'rejectionReason' => $data['rejection_reason'],
            ]);
    }
    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('KYC application update')
                    ->body($data['message'])
            )
            ->data([
                'type'             => $data['type'],
                'application_id'   => (string) $data['application_id'],
                'rejection_reason' => $data['rejection_reason'] ?? '',
            ]);
    }
}