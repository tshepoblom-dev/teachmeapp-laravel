<?php

namespace App\Services;

use App\Enums\EscrowStatus;
use App\Enums\WalletTransactionType;
use App\Models\Booking;
use App\Models\EscrowTransaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class EscrowService
{
    public function __construct(
        private readonly WalletService $walletService,
        private readonly PlatformSettingsService $settings,
    ) {}

    // -------------------------------------------------------------------------
    // HOLD — called when a booking is accepted by the tutor
    // Moves funds: student.balance → student.escrow_balance
    // -------------------------------------------------------------------------

    public function hold(Booking $booking): EscrowTransaction
    {
        return DB::transaction(function () use ($booking) {

            // Lock both wallets to prevent race conditions
            $studentWallet = Wallet::where('user_id', $booking->student_id)
                ->lockForUpdate()
                ->firstOrFail();

            $tutorWallet = Wallet::where('user_id', $booking->tutor_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ((float) $studentWallet->balance < (float) $booking->total_amount) {
                throw new RuntimeException(
                    "Insufficient wallet balance. Required: {$booking->total_amount}, Available: {$studentWallet->balance}"
                );
            }

            // Verify no existing escrow for this booking
            if (EscrowTransaction::where('booking_id', $booking->id)->exists()) {
                throw new RuntimeException("Escrow already exists for booking #{$booking->id}");
            }

            // Debit student available balance
            $this->walletService->debit(
                 $studentWallet,
                (float) $booking->total_amount,
                [
                    'type' => WalletTransactionType::EscrowHold,
                    'description' => "Escrow held for booking #{$booking->id} with {$booking->tutor->name}",
                    'reference' => "escrow_hold_{$booking->id}",
                ]
            );

            // Move to escrow balance (separate column, not a separate wallet transaction)
            $studentWallet->increment('escrow_balance', $booking->total_amount);

            $escrow = EscrowTransaction::create([
                'booking_id'        => $booking->id,
                'student_wallet_id' => $studentWallet->id,
                'tutor_wallet_id'   => $tutorWallet->id,
                'amount'            => $booking->total_amount,
                'status'            => EscrowStatus::Held,
                'held_at'           => now(),
            ]);

            Log::info('Escrow held', [
                'escrow_id'  => $escrow->id,
                'booking_id' => $booking->id,
                'amount'     => $booking->total_amount,
                'student_id' => $booking->student_id,
            ]);

            return $escrow;
        });
    }

    // -------------------------------------------------------------------------
    // RELEASE — called when session is marked completed
    // Moves funds: student.escrow_balance → tutor.balance (minus commission)
    // -------------------------------------------------------------------------

    public function release(Booking $booking, string $reason = 'Session completed successfully'): EscrowTransaction
    {
        return DB::transaction(function () use ($booking, $reason) {

            $escrow = EscrowTransaction::where('booking_id', $booking->id)
                ->whereIn('status', [EscrowStatus::Held, EscrowStatus::Disputed])
                ->lockForUpdate()
                ->firstOrFail();

            $studentWallet = Wallet::lockForUpdate()->findOrFail($escrow->student_wallet_id);
            $tutorWallet   = Wallet::lockForUpdate()->findOrFail($escrow->tutor_wallet_id);

            // Resolve commission rate: tutor tier > platform default
            $commissionRate   = $this->resolveCommissionRate($booking);
            $commissionAmount = round((float) $escrow->amount * ($commissionRate / 100), 2);
            $netToTutor       = round((float) $escrow->amount - $commissionAmount, 2);

            // Release student's escrow balance (funds leave escrow pool)
            $studentWallet->decrement('escrow_balance', $escrow->amount);

            // Credit tutor's available balance (net of commission)
            $this->walletService->credit(
                $tutorWallet,
                $netToTutor,
                [
                  'type' => WalletTransactionType::EscrowRelease,
                  'description' => "Earnings from booking #{$booking->id} ({$commissionRate}% platform fee applied)",
                  'reference' => "escrow_release_{$booking->id}",
                ]
            );

            // Record platform commission as a debit ledger entry (audit only — no wallet moves)
            // Commission is the delta between escrow.amount and net_to_tutor, captured in the escrow record.
            // We record it here so admins can query wallet_transactions for fee reporting.
            $this->walletService->recordPlatformFee(
                amount: $commissionAmount,
                bookingId: $booking->id,
                reference: "platform_fee_{$booking->id}",
            );

            $escrow->update([
                'commission_rate_snapshot' => $commissionRate,
                'commission_amount'        => $commissionAmount,
                'net_to_tutor'             => $netToTutor,
                'status'                   => EscrowStatus::Released,
                'released_at'              => now(),
                'release_reason'           => $reason,
            ]);

            Log::info('Escrow released', [
                'escrow_id'        => $escrow->id,
                'booking_id'       => $booking->id,
                'gross'            => $escrow->amount,
                'commission_rate'  => $commissionRate,
                'commission_amount'=> $commissionAmount,
                'net_to_tutor'     => $netToTutor,
                'tutor_id'         => $booking->tutor_id,
            ]);

            return $escrow->fresh();
        });
    }

    // -------------------------------------------------------------------------
    // REFUND — called on cancellation or admin dispute resolution
    // Moves funds: student.escrow_balance → student.balance
    // Supports partial refunds (e.g. late cancellation fee)
    // -------------------------------------------------------------------------

    public function refund(
        Booking $booking,
        string $reason = 'Booking cancelled',
        ?float $penaltyAmount = null,
    ): EscrowTransaction {
        return DB::transaction(function () use ($booking, $reason, $penaltyAmount) {

            $escrow = EscrowTransaction::where('booking_id', $booking->id)
                ->whereIn('status', [EscrowStatus::Held, EscrowStatus::Disputed])
                ->lockForUpdate()
                ->firstOrFail();

            $studentWallet = Wallet::lockForUpdate()->findOrFail($escrow->student_wallet_id);

            // Apply cancellation penalty if set (e.g. 50% late cancellation fee)
            $refundAmount  = (float) $escrow->amount;
            $penaltyCharge = 0.00;

            if ($penaltyAmount !== null && $penaltyAmount > 0) {
                $penaltyCharge = min($penaltyAmount, $refundAmount);
                $refundAmount  = round($refundAmount - $penaltyCharge, 2);
            }

            // Decrement escrow balance by the full original amount
            $studentWallet->decrement('escrow_balance', $escrow->amount);

            // Credit refund amount back to available balance
            if ($refundAmount > 0) {
                $this->walletService->credit(
                    $studentWallet,
                    $refundAmount,
                    [
                        'type' => WalletTransactionType::EscrowRefund,
                        'description' => "Refund for booking #{$booking->id}: {$reason}",
                        'reference' => "escrow_refund_{$booking->id}",
                    ]
                );
            }

            // If there's a penalty, record it as a platform fee
            if ($penaltyCharge > 0) {
                $this->walletService->recordPlatformFee(
                    amount: $penaltyCharge,
                    bookingId: $booking->id,
                    reference: "cancellation_fee_{$booking->id}",
                );

                Log::info('Cancellation penalty applied', [
                    'booking_id'     => $booking->id,
                    'penalty_charge' => $penaltyCharge,
                    'refund_amount'  => $refundAmount,
                ]);
            }

            $escrow->update([
                'status'         => EscrowStatus::Refunded,
                'refunded_at'    => now(),
                'release_reason' => $reason,
                // Store penalty in net_to_tutor field as negative (goes to platform, not tutor)
                'net_to_tutor'   => 0,
                'commission_amount' => $penaltyCharge,
            ]);

            Log::info('Escrow refunded', [
                'escrow_id'      => $escrow->id,
                'booking_id'     => $booking->id,
                'gross_amount'   => $escrow->amount,
                'refund_amount'  => $refundAmount,
                'penalty_charge' => $penaltyCharge,
                'student_id'     => $booking->student_id,
                'reason'         => $reason,
            ]);

            return $escrow->fresh();
        });
    }

    // -------------------------------------------------------------------------
    // DISPUTE — flag escrow for admin review without releasing or refunding
    // -------------------------------------------------------------------------

    public function flagAsDisputed(Booking $booking, string $reason): EscrowTransaction
    {
        $escrow = EscrowTransaction::where('booking_id', $booking->id)
            ->where('status', EscrowStatus::Held)
            ->firstOrFail();

        $escrow->update([
            'status'         => EscrowStatus::Disputed,
            'release_reason' => "Disputed: {$reason}",
        ]);

        Log::warning('Escrow disputed', [
            'escrow_id'  => $escrow->id,
            'booking_id' => $booking->id,
            'reason'     => $reason,
        ]);

        return $escrow->fresh();
    }

    // -------------------------------------------------------------------------
    // HELPERS
    // -------------------------------------------------------------------------
/*
    private function resolveCommissionRate(Booking $booking): float
    {
        // Prefer the snapshot on the booking itself (set when booking was created)
        if ($booking->platform_fee_snapshot && $booking->platform_fee_snapshot > 0) {
            // Check if tutor now has a tier (tier rate takes precedence if lower/higher per business rules)
            $tierRate = $booking->tutor->profile?->tutorTier?->commission_rate;
            if ($tierRate !== null) {
                return (float) $tierRate;
            }
            return (float) $booking->platform_fee_snapshot;
        }

        // Fall back to tutor tier, then platform default
        $tierRate = $booking->tutor->profile?->tutorTier?->commission_rate;
        if ($tierRate !== null) {
            return (float) $tierRate;
        }

        return (float) $this->settings->get('rates', 'default_commission_rate', 20.00);
    }
        */
    private function resolveCommissionRate(Booking $booking): float
    {
        // Always honour the rate locked at booking time
        if ($booking->platform_fee_snapshot && $booking->platform_fee_snapshot > 0) {
            return (float) $booking->platform_fee_snapshot;
        }

        // Fallback for legacy rows created before snapshot logic
        return (float) ($booking->tutor->profile?->tutorTier?->commission_rate
            ?? $this->settings->get('rates', 'default_commission_rate', 20.00));
    }
}