<?php

namespace App\Services;

use App\Events\ReportResolved;
use App\Models\AuditLog;
use App\Models\Booking;
use App\Models\EscrowTransaction;
use App\Models\Report;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * ReportService — in-session incident reports, admin action queue.
 *
 * Responsibilities:
 *  - Submit a report during or after a session
 *  - Admin actions: warn user, suspend user, dismiss report
 *  - Flag booking escrow as disputed when report is actioned
 */
class ReportService
{
    public function __construct(private readonly BookingService $bookingService) {}

    // ─── Submit ───────────────────────────────────────────────────────────────

    /**
     * Submit an in-session or post-session report.
     *
     * @param  array{
     *   reason: string,
     *   description?: string|null,
     *   action_taken: 'continue_session'|'end_session',
     * } $data
     */
    public function submit(
        User    $reporter,
        Session $session,
        array   $data,
    ): Report {
        $session->loadMissing('booking');
        $booking = $session->booking;

        // Reporter must be the student or tutor on the session
        $participants = [$booking->student_id, $booking->tutor_id];
        if (! in_array($reporter->id, $participants, true)) {
            throw new RuntimeException('You are not a participant in this session.');
        }

        // Reported is the other participant
        $reportedId = $reporter->id === $booking->student_id
            ? $booking->tutor_id
            : $booking->student_id;

        return DB::transaction(function () use ($reporter, $session, $booking, $reportedId, $data) {
            $report = Report::create([
                'session_id'   => $session->id,
                'booking_id'   => $booking->id,
                'reporter_id'  => $reporter->id,
                'reported_id'  => $reportedId,
                'reason'       => $data['reason'],
                'description'  => $data['description'] ?? null,
                'action_taken' => $data['action_taken'],
                'status'       => 'pending',
            ]);

            Log::info('Report submitted', [
                'report_id'   => $report->id,
                'reporter_id' => $reporter->id,
                'session_id'  => $session->id,
                'reason'      => $data['reason'],
            ]);

            return $report;
        });
    }

    // ─── Admin: mark under review ─────────────────────────────────────────────

    public function markUnderReview(Report $report, User $admin): Report
    {
        if ($report->status !== 'pending') {
            throw new RuntimeException('Only pending reports can be moved to under review.');
        }

        $report->update(['status' => 'under_review']);

        AuditLog::create([
            'user_id'     => $admin->id,
            'action'      => 'report_under_review',
            'target_type' => 'report',
            'target_id'   => $report->id,
        ]);

        return $report->fresh();
    }

    // ─── Admin: warn ──────────────────────────────────────────────────────────

    /**
     * Issue a formal warning to the reported user and resolve the report.
     * Optionally flags the booking escrow as disputed.
     */
    public function warn(
        Report  $report,
        User    $admin,
        string  $adminNotes,
        bool    $flagEscrow = false,
    ): Report {
        $this->assertActionable($report);

        return DB::transaction(function () use ($report, $admin, $adminNotes, $flagEscrow) {
            // Warn the reported user (persist a system note — full warning notification
            // is handled by Stage 10 email channel)
            AuditLog::create([
                'user_id'     => $admin->id,
                'action'      => 'user_warned',
                'target_type' => 'user',
                'target_id'   => $report->reported_id,
                'new_values'  => [
                    'report_id'   => $report->id,
                    'admin_notes' => $adminNotes,
                ],
            ]);

            if ($flagEscrow) {
                $this->flagEscrow($report->booking, $admin);
            }

            $report->update([
                'status'      => 'resolved',
                'admin_notes' => $adminNotes,
                'resolved_by' => $admin->id,
                'resolved_at' => now(),
            ]);

            Log::info('Report resolved — user warned', [
                'report_id'   => $report->id,
                'reported_id' => $report->reported_id,
                'admin_id'    => $admin->id,
            ]);

            ReportResolved::dispatch($report->fresh(), 'warned');

            return $report->fresh();
        });
    }

    // ─── Admin: suspend ───────────────────────────────────────────────────────

    /**
     * Suspend the reported user and resolve the report.
     *
     * @param  \Carbon\Carbon|null  $until  Null = indefinite suspension.
     */
    public function suspend(
        Report      $report,
        User        $admin,
        string      $adminNotes,
        ?\Carbon\Carbon $until = null,
        bool        $flagEscrow = false,
    ): Report {
        $this->assertActionable($report);

        return DB::transaction(function () use ($report, $admin, $adminNotes, $until, $flagEscrow) {
            $reported = User::findOrFail($report->reported_id);

            $reported->update([
                'account_status'   => 'suspended',
                'suspended_until'  => $until,
                'suspension_reason'=> "Report #{$report->id}: {$adminNotes}",
            ]);

            AuditLog::create([
                'user_id'     => $admin->id,
                'action'      => 'user_suspended',
                'target_type' => 'user',
                'target_id'   => $reported->id,
                'new_values'  => [
                    'report_id'      => $report->id,
                    'suspended_until'=> $until?->toIso8601String(),
                    'reason'         => $adminNotes,
                ],
            ]);

            if ($flagEscrow) {
                $this->flagEscrow($report->booking, $admin);
            }

            $report->update([
                'status'      => 'resolved',
                'admin_notes' => $adminNotes,
                'resolved_by' => $admin->id,
                'resolved_at' => now(),
            ]);

            Log::warning('Report resolved — user suspended', [
                'report_id'   => $report->id,
                'reported_id' => $reported->id,
                'until'       => $until?->toIso8601String(),
            ]);

            ReportResolved::dispatch($report->fresh(), 'suspended');

            return $report->fresh();
        });
    }

    // ─── Admin: dismiss ───────────────────────────────────────────────────────

    public function dismiss(Report $report, User $admin, string $adminNotes): Report
    {
        $this->assertActionable($report);

        $report->update([
            'status'      => 'dismissed',
            'admin_notes' => $adminNotes,
            'resolved_by' => $admin->id,
            'resolved_at' => now(),
        ]);

        AuditLog::create([
            'user_id'     => $admin->id,
            'action'      => 'report_dismissed',
            'target_type' => 'report',
            'target_id'   => $report->id,
            'new_values'  => ['admin_notes' => $adminNotes],
        ]);

        Log::info('Report dismissed', [
            'report_id' => $report->id,
            'admin_id'  => $admin->id,
        ]);

        ReportResolved::dispatch($report->fresh(), 'dismissed');

        return $report->fresh();
    }

    // ─── Escrow dispute flag ──────────────────────────────────────────────────

    private function flagEscrow(Booking $booking, User $admin): void
    {
        try {
            $this->bookingService->dispute(
                $booking,
                "Flagged by admin following report review."
            );

            AuditLog::create([
                'user_id'     => $admin->id,
                'action'      => 'escrow_disputed',
                'target_type' => 'booking',
                'target_id'   => $booking->id,
            ]);
        } catch (RuntimeException $e) {
            // Booking may already be disputed — log and continue
            Log::warning('Could not flag escrow as disputed', [
                'booking_id' => $booking->id,
                'reason'     => $e->getMessage(),
            ]);
        }
    }

    // ─── Guard ────────────────────────────────────────────────────────────────

    private function assertActionable(Report $report): void
    {
        if (in_array($report->status, ['resolved', 'dismissed'], true)) {
            throw new RuntimeException('This report has already been resolved.');
        }
    }
}