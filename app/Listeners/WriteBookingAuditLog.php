<?php

namespace App\Listeners;

use App\Events\BookingAccepted;
use App\Events\BookingCancelled;
use App\Events\BookingCompleted;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class WriteBookingAuditLog implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'default';

    // -------------------------------------------------------------------------
    // BookingAccepted
    // -------------------------------------------------------------------------

    public function handleBookingAccepted(BookingAccepted $event): void
    {
        $this->write(
            action: 'booking_accepted',
            targetId: $event->booking->id,
            userId: $event->booking->tutor_id,
            newValues: [
                'status'     => 'accepted',
                'student_id' => $event->booking->student_id,
                'tutor_id'   => $event->booking->tutor_id,
                'amount'     => $event->booking->total_amount,
                'subject'    => $event->booking->subject,
            ],
        );
    }

    // -------------------------------------------------------------------------
    // BookingCancelled
    // -------------------------------------------------------------------------

    public function handleBookingCancelled(BookingCancelled $event): void
    {
        $this->write(
            action: 'booking_cancelled',
            targetId: $event->booking->id,
            userId: $event->cancelledBy->id,
            newValues: [
                'status'          => 'cancelled',
                'cancelled_by'    => $event->cancelledBy->id,
                'reason'          => $event->booking->cancellation_reason,
                'penalty_applied' => $event->penaltyApplied,
            ],
            oldValues: [
                'status' => 'accepted',
            ],
        );
    }

    // -------------------------------------------------------------------------
    // BookingCompleted
    // -------------------------------------------------------------------------

    public function handleBookingCompleted(BookingCompleted $event): void
    {
        $escrow = $event->booking->escrowTransaction;

        $this->write(
            action: 'booking_completed',
            targetId: $event->booking->id,
            userId: $event->booking->tutor_id,
            newValues: [
                'status'            => 'completed',
                'net_to_tutor'      => $escrow?->net_to_tutor,
                'commission_rate'   => $escrow?->commission_rate_snapshot,
                'commission_amount' => $escrow?->commission_amount,
            ],
            oldValues: [
                'status' => 'in_progress',
            ],
        );
    }

    // -------------------------------------------------------------------------
    // Subscribe — maps multiple events to handlers on a single listener class.
    // This avoids registering three separate listener classes for audit logging.
    // -------------------------------------------------------------------------

    public function subscribe(\Illuminate\Events\Dispatcher $events): array
    {
        return [
            BookingAccepted::class   => 'handleBookingAccepted',
            BookingCancelled::class  => 'handleBookingCancelled',
            BookingCompleted::class  => 'handleBookingCompleted',
        ];
    }

    // -------------------------------------------------------------------------
    // Internal writer
    // -------------------------------------------------------------------------

    private function write(
        string  $action,
        int     $targetId,
        ?int    $userId = null,
        array   $newValues = [],
        array   $oldValues = [],
    ): void {
        try {
            AuditLog::create([
                'user_id'     => $userId,
                'action'      => $action,
                'target_type' => 'booking',
                'target_id'   => $targetId,
                'old_values'  => empty($oldValues) ? null : $oldValues,
                'new_values'  => empty($newValues) ? null : $newValues,
                'ip_address'  => null, // Not available in async context
                'user_agent'  => null,
            ]);
        } catch (\Throwable $e) {
            // Audit failure must never affect the user-facing flow
            Log::error('AuditLog write failed', [
                'action'    => $action,
                'target_id' => $targetId,
                'error'     => $e->getMessage(),
            ]);
        }
    }
}