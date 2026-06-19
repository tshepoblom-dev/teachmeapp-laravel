<?php

namespace App\Notifications;

use App\Models\Review;
use App\Services\NotificationPreferenceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class ReviewReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Review $review,
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'review_received');
    }

    public function toArray(object $notifiable): array
    {
        $reviewer = $this->review->reviewer;
        $stars    = str_repeat('★', $this->review->rating) . str_repeat('☆', 5 - $this->review->rating);

        return [
            'type'        => 'review_received',
            'review_id'   => $this->review->id,
            'booking_id'  => $this->review->booking_id,
            'rating'      => $this->review->rating,
            'stars'       => $stars,
            'comment'     => $this->review->comment,
            'reviewer_name' => $reviewer?->name ?? 'A student',
            'message'     => "{$reviewer?->name} left you a {$this->review->rating}-star review.",
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)
            ->subject('You received a new review')
            ->view('emails.review-received', [
                'message'      => $data['message'],
                'reviewerName' => $data['reviewer_name'],
                'rating'       => $data['rating'],
                'stars'        => $data['stars'],
                'comment'      => $data['comment'],
                'bookingId'    => $data['booking_id'],
            ]);
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $data = $this->toArray($notifiable);

        return FcmMessage::create()
            ->notification(
                FcmNotification::create()
                    ->title('New review ⭐')
                    ->body($data['message'])
            )
            ->data([
                'type'      => $data['type'],
                'review_id' => (string) $data['review_id'],
                'rating'    => (string) $data['rating'],
            ]);
    }
}
