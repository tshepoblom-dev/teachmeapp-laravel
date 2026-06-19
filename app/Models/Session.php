<?php
namespace App\Models;
use App\Enums\SessionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Session extends Model
{
    protected $fillable = [
        'booking_id','agora_channel_name','agora_token_student','agora_token_tutor',
        'agora_uid_student','agora_uid_tutor','started_at','ended_at','ended_by',
        'early_termination_reason','recording_enabled','recording_url','status',
    ];

    protected function casts(): array
    {
        return [
            'started_at'        => 'datetime',
            'ended_at'          => 'datetime',
            'recording_enabled' => 'boolean',
            'status'            => SessionStatus::class,
        ];
    }

    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
    public function agoraChannel(): HasOne { return $this->hasOne(AgoraChannel::class); }
    public function chatMessages(): HasMany { return $this->hasMany(ChatMessage::class); }
    public function polls(): HasMany { return $this->hasMany(SessionPoll::class); }
    public function reports(): HasMany { return $this->hasMany(Report::class); }
    public function endedBy(): BelongsTo { return $this->belongsTo(User::class, 'ended_by'); }

    public function getDurationSeconds(): int
    {
        if (!$this->started_at || !$this->ended_at) return 0;
        return $this->started_at->diffInSeconds($this->ended_at);
    }

    /**
     * A session is "expired" when it has not yet started (still Waiting) but
     * the booking's scheduled window has already elapsed.
     *
     * Logic:
     *   expiry_time = booking.scheduled_at + booking.duration_minutes
     *   expired     = now > expiry_time  AND  status is still Waiting
     *
     * Active / InProgress / Ended / Abandoned / Disputed sessions are handled
     * by their own status checks — only orphaned Waiting sessions need this.
     */
    public function isExpired(): bool
    {
        if ($this->status !== SessionStatus::Waiting) {
            return false;   // already progressed — not "expired" in this sense
        }

        $this->loadMissing('booking');

        if (! $this->booking) {
            return false;
        }

        $expiresAt = $this->booking->scheduled_at
            ->copy()
            ->addMinutes((int) $this->booking->duration_minutes);

        return now()->isAfter($expiresAt);
    }
}
