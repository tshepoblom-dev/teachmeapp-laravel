<?php

namespace App\Listeners;

use App\Events\PayoutCompleted;
use App\Notifications\PayoutCompletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendPayoutCompletedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch after the transaction commits so the payout row has
     * status='completed' before the queue worker reads it.
     */
    public bool $afterCommit = true;

    public function handle(PayoutCompleted $event): void
    {
        $payout = $event->payout->loadMissing('user');

        try {
            $payout->user->notify(
                new PayoutCompletedNotification($payout)
            );

            Log::info('PayoutCompleted notification sent', [
                'payout_id' => $payout->id,
                'user_id'   => $payout->user_id,
                'reference' => $payout->reference,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send PayoutCompleted notification', [
                'payout_id' => $payout->id,
                'error'     => $e->getMessage(),
            ]);
        }
    }
}
