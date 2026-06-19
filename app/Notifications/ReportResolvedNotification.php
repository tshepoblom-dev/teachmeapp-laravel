<?php

namespace App\Notifications;

use App\Models\Report;
use App\Services\NotificationPreferenceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class ReportResolvedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param  string  $outcome  'warned' | 'suspended' | 'dismissed'
     */
    public function __construct(
        private readonly Report $report,
        private readonly string $outcome,
    ) {}

    public function via(object $notifiable): array
    {
        return app(NotificationPreferenceService::class)
            ->resolveChannels($notifiable, 'report_resolved');
    }

    public function toArray(object $notifiable): array
    {
        $outcomeLabel = match ($this->outcome) {
            'warned'    => 'The reported user has been issued a warning.',
            'suspended' => 'The reported user has been suspended.',
            'dismissed' => 'After review, no action was required.',
            default     => 'The report has been reviewed.',
        };

        return [
            'type'          => 'report_resolved',
            'report_id'     => $this->report->id,
            'outcome'       => $this->outcome,
            'outcome_label' => $outcomeLabel,
            'admin_notes'   => $this->report->admin_notes,
            'resolved_at'   => $this->report->resolved_at?->toIso8601String(),
            'message'       => "Your report (#{$this->report->id}) has been resolved. {$outcomeLabel}",
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)
            ->subject('Your report has been resolved')
            ->view('emails.report-resolved', [
                'message'      => $data['message'],
                'reportId'     => $data['report_id'],
                'outcome'      => $data['outcome'],
                'outcomeLabel' => $data['outcome_label'],
                'adminNotes'   => $data['admin_notes'],
                'resolvedAt'   => $this->report->resolved_at
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
                    ->title('Report resolved')
                    ->body($data['message'])
            )
            ->data([
                'type'      => $data['type'],
                'report_id' => (string) $data['report_id'],
                'outcome'   => $data['outcome'],
            ]);
    }
}
