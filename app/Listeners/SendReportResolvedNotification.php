<?php

namespace App\Listeners;

use App\Events\ReportResolved;
use App\Notifications\ReportResolvedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendReportResolvedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch after commit so the report's resolved status is visible
     * to the queue worker when the job is picked up.
     */
    public bool $afterCommit = true;

    public function handle(ReportResolved $event): void
    {
        $report = $event->report->loadMissing(['reporter']);

        try {
            // Notify the person who submitted the report
            $report->reporter->notify(
                new ReportResolvedNotification($report, $event->outcome)
            );

            Log::info('ReportResolved notification sent', [
                'report_id'   => $report->id,
                'reporter_id' => $report->reporter_id,
                'outcome'     => $event->outcome,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send ReportResolved notification', [
                'report_id' => $report->id,
                'error'     => $e->getMessage(),
            ]);

            // Do not rethrow — notification failure must never affect report flow
        }
    }
}
