<?php

namespace App\Listeners;

use App\Events\PayoutFailed;
use App\Notifications\PayoutFailedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendPayoutFailedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch after commit — the wallet refund and payout status update
     * must be committed before the notification job runs.
     */
    public bool $afterCommit = true;

    public function handle(PayoutFailed $event): void
    {
        $payout = $event->payout->loadMissing('user');

        try {
            $payout->user->notify(
                new PayoutFailedNotification($payout)
            );

            Log::info('PayoutFailed notification sent', [
                'payout_id'      => $payout->id,
                'user_id'        => $payout->user_id,
                'reference'      => $payout->reference,
                'failure_reason' => $payout->failure_reason,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send PayoutFailed notification', [
                'payout_id' => $payout->id,
                'error'     => $e->getMessage(),
            ]);
        }
    }
}
