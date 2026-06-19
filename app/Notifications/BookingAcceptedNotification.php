<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Services\NotificationPreferenceService;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class BookingAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Booking $booking,
        private readonly string  $recipient, // 'student' | 'tutor'
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'booking_accepted');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'booking_accepted',
            'booking_id' => $this->booking->id,
            'subject'    => $this->booking->subject,
            'scheduled_at' => $this->booking->scheduled_at?->toIso8601String(),
            'tutor_name' => $this->booking->tutor?->name,
            'message'    => $this->recipient === 'student'
                ? "Your booking for {$this->booking->subject} has been accepted by {$this->booking->tutor?->name}."
                : "You have accepted the booking for {$this->booking->subject}.",
        ];
    }
    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Your booking has been accepted')
            ->view('emails.booking-accepted', [
                'message'     => $data['message'],
                'subject'     => $data['subject'],
                'tutorName'   => $data['tutor_name'],
                'scheduledAt' => $this->booking->scheduled_at?->copy()->setTimezone(config('app.local_timezone'))->format('D, d M Y \a\t H:i'),
                'bookingId'   => $data['booking_id'],
            ]);
    }
    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('Booking accepted ✓')
                    ->body($data['message'])
            )
            ->data([
                'type'       => $data['type'],
                'booking_id' => (string) $data['booking_id'],
            ]);
    }
}