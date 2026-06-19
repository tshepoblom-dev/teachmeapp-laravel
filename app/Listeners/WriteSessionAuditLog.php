<?php

namespace App\Listeners;

use App\Events\SessionEnded;
use App\Events\SessionStarted;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class WriteSessionAuditLog implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'default';

    // -------------------------------------------------------------------------
    // SessionStarted
    // -------------------------------------------------------------------------

    public function handleSessionStarted(SessionStarted $event): void
    {
        $this->write(
            action: 'session_started',
            targetId: $event->session->id,
            userId: $event->startedBy->id,
            newValues: [
                'status'     => 'active',
                'started_at' => $event->session->started_at?->toDateTimeString(),
                'booking_id' => $event->session->booking_id,
            ],
        );
    }

    // -------------------------------------------------------------------------
    // SessionEnded
    // -------------------------------------------------------------------------

    public function handleSessionEnded(SessionEnded $event): void
    {
        $this->write(
            action: 'session_ended',
            targetId: $event->session->id,
            userId: $event->endedBy->id,
            newValues: [
                'status'            => $event->session->status->value,
                'ended_at'          => $event->session->ended_at?->toDateTimeString(),
                'duration_seconds'  => $event->durationSeconds,
                'reason'            => $event->reason,
                'booking_id'        => $event->session->booking_id,
            ],
            oldValues: [
                'status' => 'active',
            ],
        );
    }

    // -------------------------------------------------------------------------
    // Subscribe
    // -------------------------------------------------------------------------

    public function subscribe(\Illuminate\Events\Dispatcher $events): array
    {
        return [
            SessionStarted::class => 'handleSessionStarted',
            SessionEnded::class   => 'handleSessionEnded',
        ];
    }

    // -------------------------------------------------------------------------
    // Internal writer
    // -------------------------------------------------------------------------

    private function write(
        string $action,
        int    $targetId,
        ?int   $userId = null,
        array  $newValues = [],
        array  $oldValues = [],
    ): void {
        try {
            AuditLog::create([
                'user_id'     => $userId,
                'action'      => $action,
                'target_type' => 'session',
                'target_id'   => $targetId,
                'old_values'  => empty($oldValues) ? null : $oldValues,
                'new_values'  => empty($newValues) ? null : $newValues,
                'ip_address'  => null,
                'user_agent'  => null,
            ]);
        } catch (\Throwable $e) {
            Log::error('SessionAuditLog write failed', [
                'action'    => $action,
                'target_id' => $targetId,
                'error'     => $e->getMessage(),
            ]);
        }
    }
}