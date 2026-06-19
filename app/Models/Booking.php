<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'student_id', 'tutor_id', 'subject', 'description',
        'scheduled_at', 'duration_minutes', 'hourly_rate_snapshot',
        'total_amount', 'platform_fee_snapshot', 'payment_method_id',
        'status', 'cancellation_reason', 'cancelled_by',
        'rescheduled_from_booking_id',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at'          => 'datetime',
            'hourly_rate_snapshot'  => 'decimal:2',
            'total_amount'          => 'decimal:2',
            'platform_fee_snapshot' => 'decimal:2',
            'status'                => BookingStatus::class,
        ];
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function session(): HasOne
    {
        return $this->hasOne(Session::class);
    }

    public function escrowTransaction(): HasOne
    {
        return $this->hasOne(EscrowTransaction::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public function rescheduledFrom(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'rescheduled_from_booking_id');
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopePending($query)   { return $query->where('status', BookingStatus::Pending->value); }
    public function scopeAccepted($query)  { return $query->where('status', BookingStatus::Accepted->value); }
    public function scopeCompleted($query) { return $query->where('status', BookingStatus::Completed->value); }
    public function scopeUpcoming($query)
    {
        return $query->where(function ($q) {
            $q->whereIn('status', [BookingStatus::Accepted->value])
            ->where('scheduled_at', '>=', now())
            ->orWhereIn('status', [BookingStatus::InProgress->value]);
        });
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    public function isModifiable(): bool
    {
        return in_array($this->status, [BookingStatus::Pending, BookingStatus::Accepted]);
    }

    /** Calculated total based on snapshot rate and duration */
    public static function calculateTotal(float $hourlyRate, int $durationMinutes): float
    {
        return round($hourlyRate * ($durationMinutes / 60), 2);
    }
}
