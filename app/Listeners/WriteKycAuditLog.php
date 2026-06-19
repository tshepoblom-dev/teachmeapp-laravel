<?php

namespace App\Listeners;

use App\Events\KycApproved;
use App\Events\KycRejected;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class WriteKycAuditLog implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'default';

    public function handleKycApproved(KycApproved $event): void
    {
        $this->write(
            action: 'kyc_approved',
            targetId: $event->application->id,
            userId: $event->application->reviewed_by,
            newValues: [
                'status'      => 'approved',
                'reviewed_at' => $event->application->reviewed_at?->toDateTimeString(),
                'applicant'   => $event->application->user_id,
            ],
        );
    }

    public function handleKycRejected(KycRejected $event): void
    {
        $this->write(
            action: 'kyc_rejected',
            targetId: $event->application->id,
            userId: $event->application->reviewed_by,
            newValues: [
                'status'           => 'rejected',
                'rejection_reason' => $event->application->rejection_reason,
                'reviewed_at'      => $event->application->reviewed_at?->toDateTimeString(),
                'applicant'        => $event->application->user_id,
            ],
        );
    }

    public function subscribe(\Illuminate\Events\Dispatcher $events): array
    {
        return [
            KycApproved::class => 'handleKycApproved',
            KycRejected::class => 'handleKycRejected',
        ];
    }

    private function write(
        string $action,
        int    $targetId,
        ?int   $userId,
        array  $newValues,
    ): void {
        try {
            AuditLog::create([
                'user_id'     => $userId,
                'action'      => $action,
                'target_type' => 'kyc_application',
                'target_id'   => $targetId,
                'old_values'  => null,
                'new_values'  => $newValues,
                'ip_address'  => null,
                'user_agent'  => null,
            ]);
        } catch (\Throwable $e) {
            Log::error('KycAuditLog write failed', [
                'action' => $action,
                'error'  => $e->getMessage(),
            ]);
        }
    }
}