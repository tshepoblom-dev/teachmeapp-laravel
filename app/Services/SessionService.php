<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\SessionStatus;
use App\Events\SessionEnded;
use App\Events\SessionStarted;
use App\Events\SessionStatusChanged;
use App\Models\AgoraChannel;
use App\Models\Booking;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class SessionService
{
    public function __construct(
        private readonly AgoraService            $agoraService,
        private readonly BookingService          $bookingService,
        private readonly PlatformSettingsService $settings,
    ) {}

    // =========================================================================
    // CREATE
    // Called automatically when a booking is accepted.
    // =========================================================================

    public function createForBooking(Booking $booking): Session
    {
        return DB::transaction(function () use ($booking) {

            if (Session::where('booking_id', $booking->id)->exists()) {
                throw new RuntimeException("Session already exists for booking #{$booking->id}");
            }

            $channelName = $this->agoraService->generateChannelName($booking->id);

            $session = Session::create([
                'booking_id'          => $booking->id,
                'agora_channel_name'  => $channelName,
                'agora_token_student' => null,
                'agora_token_tutor'   => null,
                'agora_uid_student'   => $this->agoraService->uidForUser($booking->student_id),
                'agora_uid_tutor'     => $this->agoraService->uidForUser($booking->tutor_id),
                'started_at'          => null,
                'ended_at'            => null,
                'recording_enabled'   => config('agora.recording_enabled', false),
                'status'              => SessionStatus::Waiting,
            ]);

            AgoraChannel::create([
                'session_id'             => $session->id,
                'channel_name'           => $channelName,
                'is_active'              => false,
                'last_keepalive_at'      => now(),
                'total_duration_seconds' => 0,
            ]);

            Log::info('Session created', [
                'session_id'   => $session->id,
                'booking_id'   => $booking->id,
                'channel_name' => $channelName,
            ]);

            return $session;
        });
    }

    // =========================================================================
    // JOIN
    // Called by both parties when they open the session page.
    //
    // Status flow:
    //   Waiting → Active  (first person joins — channel becomes live)
    //   Active  → Active  (second person joins — no status change, already live)
    //   InProgress → InProgress (re-join after disconnect — session already started)
    //
    // Broadcasting: fires SessionStatusChanged when Waiting→Active so the OTHER
    // party's page reacts in real time without a refresh.
    // =========================================================================

    public function join(Session $session, User $user): array
    {
        $booking = $session->booking;

        $this->assertIsParticipant($session, $user);

        if (! $session->status->isJoinable()) {
            throw new RuntimeException(
                "This session cannot be joined. Current status: {$session->status->label()}"
            );
        }

        // Grace period check
        $gracePeriod  = $this->settings->get('sessions', 'grace_period_minutes', 10);
        $earliestJoin = \Carbon\Carbon::parse($booking->scheduled_at)->subMinutes($gracePeriod);

        if (now()->lt($earliestJoin)) {
            $minutesUntil = (int) now()->diffInMinutes($earliestJoin);
            throw new RuntimeException(
                "Session cannot be joined yet. You may join up to {$gracePeriod} minutes before the scheduled time. Opens in {$minutesUntil} minutes."
            );
        }

        // Refresh tokens
        $tokens    = $this->agoraService->refreshTokens($session);
        $isStudent = $user->id === $booking->student_id;
        $myToken   = $isStudent ? $tokens['student'] : $tokens['tutor'];
        $myUid     = $isStudent ? $session->agora_uid_student : $session->agora_uid_tutor;

        // Activate channel on first join (Waiting → Active)
        if ($session->status === SessionStatus::Waiting) {
            $oldStatus = $session->status->value;

            $session->update(['status' => SessionStatus::Active]);

            AgoraChannel::where('session_id', $session->id)
                ->update([
                    'is_active'         => true,
                    'last_keepalive_at' => now(),
                ]);

            // Broadcast to the OTHER party's page so they see "Joined"
            SessionStatusChanged::dispatch(
                session:   $session->fresh(),
                oldStatus: $oldStatus,
                newStatus: SessionStatus::Active->value,
                changedBy: $user,
            );

            Log::info('Session first join — channel activated', [
                'session_id' => $session->id,
                'user_id'    => $user->id,
            ]);
        }

        return [
            'session_id'   => $session->id,
            'channel_name' => $session->agora_channel_name,
            'token'        => $myToken,
            'rtm_token'    => $this->agoraService->generateRtmToken($user->id),
            'uid'          => $myUid,
            'app_id'       => config('agora.app_id'),
            'expires_in'   => $this->agoraService->tokenExpiresInSeconds(),
            'role'         => 'publisher',
        ];
    }

    // =========================================================================
    // START
    // Tutor explicitly starts the session.
    //
    // Status flow: Active → InProgress
    // Sets started_at — this is the billing clock start.
    // Transitions booking to in_progress.
    // Broadcasts SessionStarted + SessionStatusChanged.
    // =========================================================================

    public function start(Session $session, User $tutor): Session
    {
        $this->assertIsTutor($session, $tutor);

        if ($session->status !== SessionStatus::Active) {
            throw new RuntimeException(
                "Session must be in 'joined' state before it can be started. Current status: {$session->status->label()}"
            );
        }

        if ($session->booking->status !== BookingStatus::Accepted) {
            throw new RuntimeException('Booking must be accepted before starting the session.');
        }

        return DB::transaction(function () use ($session, $tutor) {

            $oldStatus = $session->status->value;

            $session->update([
                'started_at' => now(),
                'status'     => SessionStatus::InProgress,
            ]);

            // Mark booking as in_progress — escrow is now locked
            $this->bookingService->markInProgress($session->booking);

            $fresh = $session->fresh();

            // Broadcast "session started" to BOTH parties' pages
            SessionStarted::dispatch($fresh, $tutor);

            SessionStatusChanged::dispatch(
                session:   $fresh,
                oldStatus: $oldStatus,
                newStatus: SessionStatus::InProgress->value,
                changedBy: $tutor,
            );

            Log::info('Session started', [
                'session_id' => $session->id,
                'tutor_id'   => $tutor->id,
                'started_at' => now()->toDateTimeString(),
            ]);

            return $fresh;
        });
    }

    // =========================================================================
    // END
    // Either party can end an Active or InProgress session.
    //
    // Status flow: Active|InProgress → Ended
    // Releases escrow to tutor via BookingService::complete().
    // Broadcasts SessionEnded + SessionStatusChanged.
    // =========================================================================

    public function end(Session $session, User $endedBy, ?string $reason = null): Session
    {
        $this->assertIsParticipant($session, $endedBy);

        if (! $session->status->isEndable()) {
            throw new RuntimeException(
                "Only active or in-progress sessions can be ended. Current status: {$session->status->label()}"
            );
        }

        return DB::transaction(function () use ($session, $endedBy, $reason) {

            $oldStatus = $session->status->value;
            $startedAt = $session->started_at ?? now();
            $duration  = (int) $startedAt->diffInSeconds(now());

            $session->update([
                'ended_at'                 => now(),
                'ended_by'                 => $endedBy->id,
                'early_termination_reason' => $reason,
                'status'                   => SessionStatus::Ended,
            ]);

            AgoraChannel::where('session_id', $session->id)
                ->update([
                    'is_active'              => false,
                    'last_keepalive_at'      => now(),
                    'total_duration_seconds' => $duration,
                ]);

            $completionReason = $reason
                ? "Session ended by {$endedBy->name}: {$reason}"
                : 'Session completed successfully';

            // Guard: if the session was ended while still in Active state (tutor
            // never clicked "Start"), the booking is still Accepted. Promote it
            // to InProgress first so BookingService::complete() doesn't reject it.
            $booking = $session->booking()->lockForUpdate()->first();
            if ($booking->status === BookingStatus::Accepted) {
                $this->bookingService->markInProgress($booking);
                $booking->refresh();
            }

            $this->bookingService->complete($booking, $completionReason);

            $fresh = $session->fresh();

            // Broadcast to BOTH parties so their pages respond immediately
            SessionEnded::dispatch(
                session:         $fresh,
                endedBy:         $endedBy,
                durationSeconds: $duration,
                reason:          $reason,
            );

            SessionStatusChanged::dispatch(
                session:   $fresh,
                oldStatus: $oldStatus,
                newStatus: SessionStatus::Ended->value,
                changedBy: $endedBy,
            );

            Log::info('Session ended', [
                'session_id'       => $session->id,
                'ended_by'         => $endedBy->id,
                'duration_seconds' => $duration,
                'reason'           => $reason,
            ]);

            return $fresh;
        });
    }

    // =========================================================================
    // ABANDON
    // System-level action for timed-out sessions with no activity.
    // =========================================================================

    public function abandon(Session $session, string $reason = 'No activity detected'): Session
    {
        if (! in_array($session->status, [
            SessionStatus::Waiting,
            SessionStatus::Active,
            SessionStatus::InProgress,
        ], true)) {
            throw new RuntimeException("Cannot abandon a session with status: {$session->status->label()}");
        }

        return DB::transaction(function () use ($session, $reason) {

            $session->update([
                'ended_at'                 => now(),
                'early_termination_reason' => $reason,
                'status'                   => SessionStatus::Abandoned,
            ]);

            AgoraChannel::where('session_id', $session->id)
                ->update(['is_active' => false]);
            // Promote to InProgress first if still Accepted, so dispute() accepts it
            $booking = $session->booking;
            if ($booking->status === BookingStatus::Accepted) {
                $this->bookingService->markInProgress($booking);
                $booking->refresh();
            }
            $this->bookingService->dispute(
                booking: $session->booking,
                reason: "Session abandoned: {$reason}",
            );

            Log::warning('Session abandoned', [
                'session_id' => $session->id,
                'reason'     => $reason,
            ]);

            return $session->fresh();
        });
    }

    // =========================================================================
    // KEEPALIVE — client pings every 30s while in session
    // =========================================================================

    public function keepalive(Session $session, User $user): void
    {
        $this->assertIsParticipant($session, $user);

        AgoraChannel::where('session_id', $session->id)
            ->update(['last_keepalive_at' => now()]);
    }

    // =========================================================================
    // REFRESH TOKEN — called when token is about to expire (< 5 min remaining)
    // =========================================================================

    public function refreshToken(Session $session, User $user): array
    {
        $this->assertIsParticipant($session, $user);

        if (! $session->status->isLive()) {
            throw new RuntimeException('Token refresh is only available for live sessions.');
        }

        $tokens    = $this->agoraService->refreshTokens($session);
        $isStudent = $user->id === $session->booking->student_id;

        return [
            'token'      => $isStudent ? $tokens['student'] : $tokens['tutor'],
            'uid'        => $isStudent ? $session->agora_uid_student : $session->agora_uid_tutor,
            'expires_in' => $this->agoraService->tokenExpiresInSeconds(),
        ];
    }

    // =========================================================================
    // AUTO-END — called by scheduled job for overdue sessions
    // =========================================================================

    public function checkAndAutoEnd(): void
    {
        $maxMinutes = $this->settings->get('sessions', 'auto_end_minutes', 120);

        // Check both Active and InProgress sessions
        $overdueSessions = Session::whereIn('status', [
                SessionStatus::Active->value,
                SessionStatus::InProgress->value,
            ])
            ->whereNotNull('started_at')
            ->where('started_at', '<=', now()->subMinutes($maxMinutes))
            ->with('booking')
            ->get();

        foreach ($overdueSessions as $session) {
            try {
                $tutor = $session->booking->tutor;
                $this->end(
                    session: $session,
                    endedBy: $tutor,
                    reason:  "Session automatically ended after {$maxMinutes} minutes",
                );

                Log::info('Session auto-ended', [
                    'session_id'  => $session->id,
                    'max_minutes' => $maxMinutes,
                ]);
            } catch (\Throwable $e) {
                Log::error('Session auto-end failed', [
                    'session_id' => $session->id,
                    'error'      => $e->getMessage(),
                ]);
            }
        }
    }

    // =========================================================================
    // PRIVATE GUARDS
    // =========================================================================

    private function assertIsParticipant(Session $session, User $user): void
    {
        $booking = $session->booking;

        $isAdmin   = $user->role->value === 'admin';
        $isStudent = $user->id === $booking->student_id;
        $isTutor   = $user->id === $booking->tutor_id;

        if (! $isAdmin && ! $isStudent && ! $isTutor) {
            throw new RuntimeException('You are not a participant in this session.');
        }
    }

    private function assertIsTutor(Session $session, User $user): void
    {
        if ($user->id !== $session->booking->tutor_id) {
            throw new RuntimeException('Only the tutor can perform this action.');
        }
    }
}
