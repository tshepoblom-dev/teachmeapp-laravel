<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Services\NotificationPreferenceService;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class BookingDeclinedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Booking $booking,
        private readonly User    $declinedBy,
        private readonly ?float  $penaltyApplied = null,
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'booking_declined');
    }

    public function toArray(object $notifiable): array
    {
        $penalty = $this->penaltyApplied
            ? " A cancellation fee of R{$this->penaltyApplied} was applied."
            : '';

        return [
            'type'            => 'booking_declined',
            'booking_id'      => $this->booking->id,
            'subject'         => $this->booking->subject,
            'scheduled_at'    => $this->booking->scheduled_at?->copy()->setTimezone(config('app.timezone'))->toIso8601String(),
            'declined_by'    => $this->declinedBy->name,
            'penalty_applied' => $this->penaltyApplied,
            'message'         => "Your booking for {$this->booking->subject} was declined by {$this->declinedBy->name}.{$penalty}",
        ];
    }
    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Booking declined')
            ->view('emails.booking-declined', [
                'message'        => $data['message'],
                'subject'        => $data['subject'],
                'declinedBy'    => $data['declined_by'],
                'penaltyApplied' => $data['penalty_applied'],
                'bookingId'      => $data['booking_id'],
            ]);
    }
    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('Booking declined')
                    ->body($data['message'])
            )
            ->data([
                'type'       => $data['type'],
                'booking_id' => (string) $data['booking_id'],
            ]);
    }
}