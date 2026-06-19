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

class PayoutCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly PayoutTransaction $payout,
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'payout_completed');
    }

    public function toArray(object $notifiable): array
    {
        $amount = number_format((float) $this->payout->amount, 2);

        return [
            'type'        => 'payout_completed',
            'payout_id'   => $this->payout->id,
            'reference'   => $this->payout->reference,
            'amount'      => (float) $this->payout->amount,
            'processed_at' => $this->payout->processed_at?->toIso8601String(),
            'message'     => "Your payout of R{$amount} ({$this->payout->reference}) has been processed successfully.",
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)
            ->subject('Your payout has been processed')
            ->view('emails.payout-completed', [
                'message'     => $data['message'],
                'reference'   => $data['reference'],
                'amount'      => number_format($data['amount'], 2),
                'processedAt' => $this->payout->processed_at
                    ?->copy()->setTimezone(config('app.local_timezone', 'UTC'))
                    ->format('D, d M Y \a\t H:i'),
            ]);
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('Payout successful 💸')
                    ->body($data['message'])
            )
            ->data([
                'type'      => $data['type'],
                'payout_id' => (string) $data['payout_id'],
                'reference' => $data['reference'],
                'amount'    => (string) $data['amount'],
            ]);
    }
}
