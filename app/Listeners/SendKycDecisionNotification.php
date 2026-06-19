<?php

namespace App\Listeners;

use App\Events\KycApproved;
use App\Events\KycRejected;
use App\Notifications\KycApprovedNotification;
use App\Notifications\KycRejectedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendKycDecisionNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    public function handleKycApproved(KycApproved $event): void
    {
        try {
            $event->application->user->notify(
                new KycApprovedNotification($event->application)
            );

            Log::info('KycApproved notification sent', [
                'application_id' => $event->application->id,
                'user_id'        => $event->application->user_id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send KycApproved notification', [
                'application_id' => $event->application->id,
                'error'          => $e->getMessage(),
            ]);
        }
    }

    public function handleKycRejected(KycRejected $event): void
    {
        try {
            $event->application->user->notify(
                new KycRejectedNotification($event->application)
            );

            Log::info('KycRejected notification sent', [
                'application_id' => $event->application->id,
                'user_id'        => $event->application->user_id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send KycRejected notification', [
                'application_id' => $event->application->id,
                'error'          => $e->getMessage(),
            ]);
        }
    }

    public function subscribe(\Illuminate\Events\Dispatcher $events): array
    {
        return [
            KycApproved::class => 'handleKycApproved',
            KycRejected::class => 'handleKycRejected',
        ];
    }
}