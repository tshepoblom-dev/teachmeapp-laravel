<?php

namespace App\Listeners;

use App\Events\BookingCompleted;
use App\Jobs\EvaluateTutorTier;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DispatchTierEvaluation implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'default';

    public function handle(BookingCompleted $event): void
    {
        $tutorId = $event->booking->tutor_id;

        EvaluateTutorTier::dispatch($tutorId)
            ->onQueue('default')
            ->delay(now()->addSeconds(5));

        Log::info('TierEvaluationJob dispatched', [
            'tutor_id'   => $tutorId,
            'booking_id' => $event->booking->id,
        ]);
    }
}