<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Services\NotificationPreferenceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

/**
 * Sent to a tutor when a student submits a new booking request.
 * Fixes §1e: tutors were never notified of incoming booking requests.
 */
class BookingRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Booking $booking,
    ) {
        $this->onQueue('notifications');
    }

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'booking_request');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'booking_request',
            'booking_id'   => $this->booking->id,
            'subject'      => $this->booking->subject,
            'student_name' => $this->booking->student?->name,
            'scheduled_at' => $this->booking->scheduled_at?->toIso8601String(),
            'message'      => "New booking request for {$this->booking->subject} from {$this->booking->student?->name}.",
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)
            ->subject('New booking request')
            ->line($data['message'])
            ->line('Please log in to accept or decline the request.')
            ->action('View booking', url("/bookings/{$this->booking->id}"));
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('New booking request 📅')
                    ->body($data['message'])
            )
            ->data([
                'type'       => $data['type'],
                'booking_id' => (string) $data['booking_id'],
            ]);
    }
}
