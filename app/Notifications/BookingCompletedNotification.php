<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Services\NotificationPreferenceService;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class BookingCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Booking $booking,
        private readonly string  $recipient, // 'student' | 'tutor'
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'booking_completed');
    }

    public function toArray(object $notifiable): array
    {
        $escrow = $this->booking->escrowTransaction;

        return [
            'type'        => 'booking_completed',
            'booking_id'  => $this->booking->id,
            'subject'     => $this->booking->subject,
            'message'     => $this->recipient === 'student'
                ? "Your session for {$this->booking->subject} is complete. Please leave a review!"
                : "Session complete. R{$escrow?->net_to_tutor} has been added to your wallet.",
            'net_earned'  => $this->recipient === 'tutor'
                ? (float) $escrow?->net_to_tutor
                : null,
        ];
    }

    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Session complete — invoice attached')
            ->view('emails.booking-completed', [
                'message'   => $data['message'],
                'subject'   => $data['subject'],
                'netEarned' => $data['net_earned'],
                'recipient' => $this->recipient,
                'bookingId' => $data['booking_id'],
            ]);
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        // FCM data values MUST all be strings — use array_filter to drop nulls,
        // then cast every surviving value to string.
        $fcmData = array_filter([
            'type'       => $data['type'],
            'booking_id' => (string) $data['booking_id'],
            'net_earned' => $data['net_earned'] !== null
                ? (string) $data['net_earned']
                : null,
        ], fn ($v) => $v !== null);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('Session complete')
                    ->body($data['message'])
            )
            ->data($fcmData);
    }
}
