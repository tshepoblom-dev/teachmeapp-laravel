<?php

namespace App\Notifications;

use App\Models\TutorTier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Services\NotificationPreferenceService;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class TutorTierUpgradedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly TutorTier $tier,
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'tier_upgraded');
    }

    public function toArray(object $_notifiable): array
    {
        return [
            'type'            => 'tier_upgraded',
            'tier_name'       => $this->tier->name,
            'tier_slug'       => $this->tier->slug,
            'commission_rate' => (float) $this->tier->commission_rate,
            'badge_icon_url'  => $this->tier->badge_icon_url,
            'message'         => "Congratulations! You've reached {$this->tier->name} tier. Your new commission rate is " . number_format((float) $this->tier->commission_rate, 2) . "%.",
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)
            ->subject('Congratulations — tier upgrade')
            ->view('emails.tier-upgraded', [
                'body'           => $data['message'],
                'tierName'       => $data['tier_name'],
                'commissionRate' => $data['commission_rate'],
            ]);
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('Tier upgrade! 🏆')
                    ->body($data['message'])
            )
            ->data([
                'type'            => $data['type'],
                'tier_name'       => $data['tier_name'],
                'tier_slug'       => $data['tier_slug'],
                'commission_rate' => (string) $this->tier->commission_rate,
            ]);
    }
}