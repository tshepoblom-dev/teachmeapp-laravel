<?php

namespace App\Notifications;

use App\Models\PayoutTransaction;
use App\Services\NotificationPreferenceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class PayoutFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly PayoutTransaction $payout,
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'payout_failed');
    }

    public function toArray(object $notifiable): array
    {
        $amount = number_format((float) $this->payout->amount, 2);

        return [
            'type'           => 'payout_failed',
            'payout_id'      => $this->payout->id,
            'reference'      => $this->payout->reference,
            'amount'         => (float) $this->payout->amount,
            'failure_reason' => $this->payout->failure_reason,
            'message'        => "Your payout of R{$amount} ({$this->payout->reference}) could not be processed. The amount has been refunded to your wallet.",
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)
            ->subject('Payout failed — funds returned to wallet')
            ->view('emails.payout-failed', [
                'message'       => $data['message'],
                'reference'     => $data['reference'],
                'amount'        => number_format($data['amount'], 2),
                'failureReason' => $data['failure_reason'],
            ]);
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('Payout failed')
                    ->body($data['message'])
            )
            ->data(array_filter([
                'type'           => $data['type'],
                'payout_id'      => (string) $data['payout_id'],
                'reference'      => $data['reference'],
                'amount'         => (string) $data['amount'],
                'failure_reason' => $data['failure_reason'],
            ]));
    }
}
