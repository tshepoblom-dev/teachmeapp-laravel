<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\EscrowStatus;
use App\Enums\KycStatus;
use App\Models\Booking;
use App\Models\EscrowTransaction;
use App\Models\Profile;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use App\Events\BookingAccepted;
use App\Events\BookingCancelled;
use App\Events\BookingCompleted;
use App\Events\BookingDeclined;
use App\Notifications\BookingRequestNotification;

class BookingService
{
    public function __construct(
        private readonly EscrowService           $escrowService,
        private readonly WalletService           $walletService,
        private readonly PlatformSettingsService $settings,
        private readonly AvailabilityService $availabilityService,  // add this
    ) {}

    // =========================================================================
    // CREATE
    // Validates availability, calculates totals, creates booking record.
    // Does NOT hold escrow yet — escrow is held on tutor acceptance.
    // =========================================================================

    public function create(User $student, array $data): Booking
    {
        return DB::transaction(function () use ($student, $data) {

            $tutor   = User::with('profile')->findOrFail($data['tutor_id']);
            $profile = $tutor->profile;

            // --- Guard: tutor must be active and available ---
            $this->assertTutorIsBookable($tutor, $profile);

            // --- Guard: duration must be in allowed list ---
            $allowedDurations = $this->settings->get('sessions', 'duration_options', [30, 60, 90, 120]);
            if (! in_array((int) $data['duration_minutes'], $allowedDurations, true)) {
                throw new RuntimeException(
                    'Invalid session duration. Allowed: ' . implode(', ', $allowedDurations) . ' minutes.'
                );
            }

            // --- Guard: scheduled_at must be in the future ---
            $scheduledAt = Carbon::parse($data['scheduled_at'])->utc();
            if ($scheduledAt->isPast()) {
                throw new RuntimeException('Scheduled time must be in the future.');
            }

            // --- Guard: not too far in the future ---
            $maxFutureDays = $this->settings->get('features', 'max_future_days_booking', 30);
            if ($scheduledAt->diffInDays(now()) > $maxFutureDays) {
                throw new RuntimeException("Sessions can only be booked up to {$maxFutureDays} days in advance.");
            }

            // --- Guard: tutor availability slot check (start must be inside a window) ---
            $this->assertTutorAvailableAt($tutor->id, $scheduledAt, (int) $data['duration_minutes']);

            // --- Soft check: does the session end past the window? (non-blocking) ---
           // $overflowsWindow = $this->sessionOverflowsWindow($tutor->id, $scheduledAt, (int) $data['duration_minutes']);
           
            // --- Guard: no overlapping bookings for this tutor ---
            $this->assertNoTutorBookingConflict($tutor->id, $scheduledAt, (int) $data['duration_minutes']);

            // --- Guard: no overlapping bookings for this student ---
            $this->assertNoStudentBookingConflict($student->id, $scheduledAt, (int) $data['duration_minutes']);

            // --- Guard: student has enough wallet balance ---
            $hourlyRate    = (float) $profile->hourly_rate;
            $totalAmount   = $this->calculateTotal($hourlyRate, (int) $data['duration_minutes']);
            $studentWallet = Wallet::where('user_id', $student->id)->firstOrFail();

            if ((float) $studentWallet->balance < $totalAmount) {
                throw new RuntimeException(
                    "Insufficient wallet balance. Session costs R{$totalAmount}. Your balance: R{$studentWallet->balance}."
                );
            }

            // --- Snapshot commission rate at booking time ---
            $commissionRate = $profile->tutorTier?->commission_rate
                ?? $this->settings->get('rates', 'default_commission_rate', 20.00);

            $booking = Booking::create([
                'student_id'                  => $student->id,
                'tutor_id'                    => $tutor->id,
                'subject'                     => $data['subject'],
                'description'                 => $data['description'] ?? null,
                'scheduled_at'                => $scheduledAt,
                'duration_minutes'            => (int) $data['duration_minutes'],
                'hourly_rate_snapshot'        => $hourlyRate,
                'total_amount'                => $totalAmount,
                'platform_fee_snapshot'       => $commissionRate,
                'payment_method_id'           => $data['payment_method_id'] ?? null,
                'status'                      => BookingStatus::Pending,
               // 'overflows_window'            => $overflowsWindow,
                'rescheduled_from_booking_id' => $data['rescheduled_from_booking_id'] ?? null,
            ]);

            Log::info('Booking created', [
                'booking_id' => $booking->id,
                'student_id' => $student->id,
                'tutor_id'   => $tutor->id,
                'amount'     => $totalAmount,
                'scheduled'  => $scheduledAt->toDateTimeString(),
            ]);

            // Notify the tutor of the new incoming booking request (§1e fix)
            $tutor->notify(new BookingRequestNotification($booking));

            return $booking;
        });
    }

    // =========================================================================
    // ACCEPT
    // Tutor accepts → status: accepted → escrow held
    // =========================================================================

    public function accept(Booking $booking, User $tutor): Booking
    {
        $this->assertTutor($booking, $tutor);
        $this->assertBookingInStatus($booking, BookingStatus::Pending, 'accept');

        return DB::transaction(function () use ($booking) {

            $booking->update(['status' => BookingStatus::Accepted]);

            // Hold escrow immediately on acceptance
            $this->escrowService->hold($booking);

            Log::info('Booking accepted', ['booking_id' => $booking->id]);

            $updated = $booking->fresh();

            // Create session record (lazy resolve to avoid circular dependency)
            app(SessionService::class)->createForBooking($updated);

            BookingAccepted::dispatch($updated);

            return $updated;
        });
    }

    // =========================================================================
    // DECLINE
    // Tutor declines → status: declined → no escrow to release (none was held)
    // =========================================================================

    public function decline(Booking $booking, User $tutor, ?string $reason = null): Booking
    {
        $this->assertTutor($booking, $tutor);
        $this->assertBookingInStatus($booking, BookingStatus::Pending, 'decline');

        $booking->update([
            'status'               => BookingStatus::Declined,
            'cancellation_reason'  => $reason,
            'cancelled_by'         => $tutor->id,
        ]);

        Log::info('Booking declined', ['booking_id' => $booking->id, 'tutor_id' => $tutor->id]);
        $updated = $booking->fresh();
        BookingDeclined::dispatch($updated, $tutor, null);
        return $updated;
    }

    // =========================================================================
    // CANCEL
    // Either party cancels.
    // If escrow is held (booking was accepted) → refund with optional penalty.
    // If booking was only pending → just update status.
    // =========================================================================

    public function cancel(Booking $booking, User $cancelledBy, ?string $reason = null): Booking
    {
        $this->assertCanCancel($booking, $cancelledBy);

        return DB::transaction(function () use ($booking, $cancelledBy, $reason) {

            $penalty = $this->resolveCancellationPenalty($booking, $cancelledBy);

            // If escrow was held, refund it (possibly with penalty)
            $escrow = EscrowTransaction::where('booking_id', $booking->id)
                ->whereIn('status', [EscrowStatus::Held, EscrowStatus::Disputed])
                ->first();

            if ($escrow) {
                $this->escrowService->refund(
                    booking: $booking,
                    reason: $reason ?? 'Booking cancelled',
                    penaltyAmount: $penalty,
                );
            }

            $booking->update([
                'status'              => BookingStatus::Cancelled,
                'cancellation_reason' => $reason,
                'cancelled_by'        => $cancelledBy->id,
            ]);

            Log::info('Booking cancelled', [
                'booking_id'   => $booking->id,
                'cancelled_by' => $cancelledBy->id,
                'penalty'      => $penalty,
            ]);
            BookingCancelled::dispatch($booking->fresh(), $cancelledBy, $penalty ?? null);
            return $booking->fresh();
        });
    }

    // =========================================================================
    // COMPLETE
    // Called by system after session ends.
    // Releases escrow → tutor paid (minus commission).
    // Updates tutor session count (tier evaluation dispatched separately).
    // =========================================================================

    public function complete(Booking $booking, string $reason = 'Session completed'): Booking
    {
        $this->assertBookingInStatus($booking, BookingStatus::InProgress, 'complete');

        return DB::transaction(function () use ($booking, $reason) {

            $this->escrowService->release($booking, $reason);

            $booking->update(['status' => BookingStatus::Completed]);

            // Increment session counts on profiles
            Profile::where('user_id', $booking->tutor_id)
                ->increment('total_sessions_hosted');

            Profile::where('user_id', $booking->student_id)
                ->increment('total_sessions_attended');

            Log::info('Booking completed', ['booking_id' => $booking->id]);
            BookingCompleted::dispatch($booking->fresh());
            return $booking->fresh();
        });
    }

    // =========================================================================
    // START (called when session begins — marks booking in_progress)
    // =========================================================================

    public function markInProgress(Booking $booking): Booking
    {
        $this->assertBookingInStatus($booking, BookingStatus::Accepted, 'start');

        $booking->update(['status' => BookingStatus::InProgress]);

        return $booking->fresh();
    }

    // =========================================================================
    // DISPUTE — admin action
    // =========================================================================

    public function dispute(Booking $booking, string $reason): Booking
    {
        if (! in_array($booking->status, [BookingStatus::InProgress, BookingStatus::Completed], true)) {
            throw new RuntimeException("Only in-progress or completed bookings can be disputed.");
        }

        DB::transaction(function () use ($booking, $reason) {
            $this->escrowService->flagAsDisputed($booking, $reason);
            $booking->update(['status' => BookingStatus::Disputed]);
        });

        return $booking->fresh();
    }

    // =========================================================================
    // AVAILABILITY HELPERS
    // =========================================================================

    /**
     * Return tutor's booked slots for a given date range.
     * Used by the availability/calendar endpoints.
     */
    public function getTutorBookedSlots(int $tutorId, Carbon $from, Carbon $to): \Illuminate\Support\Collection
    {
        return Booking::where('tutor_id', $tutorId)
            ->whereNotIn('status', [
                BookingStatus::Cancelled,
                BookingStatus::Declined,
            ])
            ->whereBetween('scheduled_at', [$from, $to])
            ->get(['id', 'scheduled_at', 'duration_minutes', 'status']);
    }

    // =========================================================================
    // CALCULATION HELPERS
    // =========================================================================

    public function calculateTotal(float $hourlyRate, int $durationMinutes): float
    {
        return round($hourlyRate * ($durationMinutes / 60), 2);
    }

    // =========================================================================
    // GUARD ASSERTIONS (private)
    // =========================================================================

    private function assertTutorIsBookable(User $tutor, ?Profile $profile): void
    {
        if ($tutor->account_status->value !== 'active') {
            throw new RuntimeException('This tutor account is not currently active.');
        }

        if (! $profile) {
            throw new RuntimeException('Tutor profile not found.');
        }

        if (! $profile->is_available) {
            throw new RuntimeException('This tutor is not currently accepting bookings.');
        }

        $kycRequired = $this->settings->get('kyc', 'require_kyc_for_tutors', true);
        if ($kycRequired && $profile->kyc_status !== KycStatus::Approved) {
            throw new RuntimeException('This tutor has not completed identity verification.');
        }

        if (! $profile->hourly_rate) {
            throw new RuntimeException('This tutor has not set an hourly rate yet.');
        }

        $minRate = $this->settings->get('rates', 'minimum_hourly_rate', 50.00);
        if ((float) $profile->hourly_rate < (float) $minRate) {
            throw new RuntimeException("Tutor's hourly rate is below the platform minimum of R{$minRate}.");
        }
    }
    /**
     * Hard guard — the session must START inside one of the tutor's active
     * availability windows.  Whether it *ends* inside the window is a soft
     * concern (windowOverflow) handled in the UI and surfaced to the tutor
     * on the booking card; it does NOT block creation here.
     *
     * This mirrors the frontend generateSlots change:
     *   Before: t + durationMins <= wEnd   (full duration must fit)
     *   After:  t < wEnd                   (start must be inside window)
     */
    private function assertTutorAvailableAt(int $tutorId, Carbon $scheduledAt, int $durationMinutes): void
    {
         // $scheduledAt arrives as UTC (the frontend always sends an ISO-8601 UTC
        // string).  Availability slots are stored in app-local time (e.g. SAST),
        // so we must convert before extracting H:i:s and day-of-week — otherwise
        // a 03:00 SAST slot is compared against "01:00" UTC and always fails.
        $local = $scheduledAt->copy()->setTimezone(config('app.local_timezone'));
 
        $dayOfWeek = $local->dayOfWeekIso - 1; // Mon=0 … Sun=6
        $timeStr   = $local->format('H:i:s');
 
        // We only require that the session *starts* inside an active availability
        // window.  If the requested duration extends past the window's end time
        // the booking is still created as pending — the tutor can accept or
        // decline the overrun at their discretion.
        // Actual booking-on-booking conflicts are caught separately by
        // assertNoTutorBookingConflict(), which is the real hard guard.

        $startsInWindow = \App\Models\TutorAvailabilitySlot::where('tutor_id', $tutorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->where('start_time', '<=', $timeStr)   // window has started
            ->where('end_time',   '>',  $timeStr)   // window has not ended yet — start only, not end
            ->where(function ($q) use ($local) {
                $q->whereNull('valid_from')
                  ->orWhere('valid_from', '<=', $local->toDateString());
            })
            ->where(function ($q) use ($local) {
                $q->whereNull('valid_until')
                  ->orWhere('valid_until', '>=', $local->toDateString());
            })
            ->exists();

        if (! $startsInWindow) {
            throw new RuntimeException(
                'The tutor is not available at the requested time. Please check their availability schedule.'
            );
        }
    }

    /**
     * Soft check — returns true when the session end time falls outside the
     * tutor's availability window.  Does NOT throw; callers use the return
     * value to annotate the booking record or notify the tutor.
     */
    public function sessionOverflowsWindow(int $tutorId, Carbon $scheduledAt, int $durationMinutes): bool
    {
        $local     = $scheduledAt->copy()->setTimezone(config('app.local_timezone'));
        $dayOfWeek = $local->dayOfWeekIso - 1;
        $timeStr   = $local->format('H:i:s');
        $endStr    = $local->copy()->addMinutes($durationMinutes)->format('H:i:s');
        // If at least one window fully contains the session, there is no overflow.
        $fitsCompletely = \App\Models\TutorAvailabilitySlot::where('tutor_id', $tutorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->where('start_time', '<=', $timeStr)
            ->where('end_time',   '>=', $endStr)
            ->where(function ($q) use ($scheduledAt) {
                $q->whereNull('valid_from')
                  ->orWhere('valid_from', '<=', $scheduledAt->toDateString());
            })
            ->where(function ($q) use ($scheduledAt) {
                $q->whereNull('valid_until')
                  ->orWhere('valid_until', '>=', $scheduledAt->toDateString());
            })
            ->exists();

        return ! $fitsCompletely;
    }
    private function assertNoTutorBookingConflict(int $tutorId, Carbon $scheduledAt, int $durationMinutes): void
    {
        $buffer  = $this->settings->get('sessions', 'session_buffer_minutes', 15);
        $starts  = $scheduledAt->copy()->subMinutes($buffer);
        $ends    = $scheduledAt->copy()->addMinutes($durationMinutes + $buffer);

        $conflict = Booking::where('tutor_id', $tutorId)
            ->whereNotIn('status', [BookingStatus::Cancelled, BookingStatus::Declined])
            ->where(function ($q) use ($starts, $ends) {
                $q->whereBetween('scheduled_at', [$starts, $ends])
                 ->orWhereRaw(
                            'DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE) BETWEEN ? AND ?',
                            [$starts, $ends]
                        )
                  ->orWhere(function ($q) use ($starts, $ends) {
                        // Existing booking fully wraps the new booking's window
                        $q->where('scheduled_at', '<', $starts)
                          ->whereRaw(
                              'DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE) > ?',
                              [$ends]
                          );
                    });
            })
            ->exists();

        if ($conflict) {
            throw new RuntimeException(
                'The tutor already has a booking that overlaps with this time (including buffer time).'
            );
        }
    }

    private function assertNoStudentBookingConflict(int $studentId, Carbon $scheduledAt, int $durationMinutes): void
    {
        $starts = $scheduledAt->copy();
        $ends   = $scheduledAt->copy()->addMinutes($durationMinutes);

        $conflict = Booking::where('student_id', $studentId)
            ->whereNotIn('status', [BookingStatus::Cancelled, BookingStatus::Declined])
            ->where(function ($q) use ($starts, $ends) {
                $q->whereBetween('scheduled_at', [$starts, $ends])
                  ->orWhereRaw(
                        'DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE) BETWEEN ? AND ?',
                        [$starts, $ends]
                    )
                  ->orWhere(function ($q) use ($starts, $ends) {
                        // Existing booking fully wraps the new booking's window
                        $q->where('scheduled_at', '<', $starts)
                          ->whereRaw(
                              'DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE) > ?',
                              [$ends]
                          );
                    });
            })
            ->exists();

        if ($conflict) {
            throw new RuntimeException('You already have a booking that overlaps with this time.');
        }
    }

    private function assertTutor(Booking $booking, User $user): void
    {
        if ($booking->tutor_id !== $user->id) {
            throw new RuntimeException('You are not the tutor for this booking.');
        }
    }

    private function assertBookingInStatus(Booking $booking, BookingStatus $expected, string $action): void
    {
        if ($booking->status !== $expected) {
            throw new RuntimeException(
                "Cannot {$action} a booking with status '{$booking->status->value}'. Expected: '{$expected->value}'."
            );
        }
    }

    private function assertCanCancel(Booking $booking, User $user): void
    {
        $cancellableStatuses = [BookingStatus::Pending, BookingStatus::Accepted];

        if (! in_array($booking->status, $cancellableStatuses, true)) {
            throw new RuntimeException(
                "Cannot cancel a booking with status '{$booking->status->value}'."
            );
        }

        $isStudent = $booking->student_id === $user->id;
        $isTutor   = $booking->tutor_id === $user->id;
        $isAdmin   = $user->role->value === 'admin';

        if (! $isStudent && ! $isTutor && ! $isAdmin) {
            throw new RuntimeException('You do not have permission to cancel this booking.');
        }
    }

    /**
     * Calculate cancellation penalty amount.
     * Penalty only applies if:
     *  - Booking was accepted (escrow held)
     *  - The cancellation is within the lead time window
     *  - The cancellation was initiated by the student
     */
    private function resolveCancellationPenalty(Booking $booking, User $cancelledBy): ?float
    {
        // No penalty on pending bookings (escrow not yet held)
        if ($booking->status === BookingStatus::Pending) {
            return null;
        }

        // No penalty if tutor cancels (student gets full refund)
        if ($cancelledBy->id === $booking->tutor_id) {
            return null;
        }

        // No penalty if admin cancels
        if ($cancelledBy->role->value === 'admin') {
            return null;
        }

        // Check if within the free cancellation window
        $leadTimeHours  = $this->settings->get('bookings', 'cancellation_lead_time_hours', 24);
        $hoursUntilStart = now()->diffInHours(Carbon::parse($booking->scheduled_at), false);

        if ($hoursUntilStart >= $leadTimeHours) {
            return null; // Within free cancellation window
        }

        // Apply late cancellation fee
        $feePercent = $this->settings->get('bookings', 'cancellation_fee_percent', 50);

        return round((float) $booking->total_amount * ($feePercent / 100), 2);
    }
    public function resolveDispute(Booking $booking, User $admin, string $action, string $reason): Booking
    {
        if ($booking->status !== BookingStatus::Disputed) {
            throw new RuntimeException('Only disputed bookings can be resolved.');
        }

        return DB::transaction(function () use ($booking, $admin, $action, $reason) {
            if ($action === 'release') {
                // Bypass the InProgress check — disputed bookings release directly
                $this->escrowService->release($booking, "Admin release: {$reason}");
                $booking->update(['status' => BookingStatus::Completed]);
            } else {
                // Refund the escrow directly — bypasses assertCanCancel
                $this->escrowService->refund($booking, "Admin refund: {$reason}");
                $booking->update(['status' => BookingStatus::Refunded]);
            }

            Log::info('Dispute resolved by admin', [
                'booking_id' => $booking->id,
                'action'     => $action,
                'admin_id'   => $admin->id,
            ]);

            return $booking->fresh();
        });
    }
}