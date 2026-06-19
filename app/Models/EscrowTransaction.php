<?php
namespace App\Models;
use App\Enums\EscrowStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EscrowTransaction extends Model
{
    protected $fillable = [
        'booking_id','student_wallet_id','tutor_wallet_id','amount',
        'commission_rate_snapshot','commission_amount','net_to_tutor',
        'status','held_at','released_at','refunded_at','release_reason',
    ];
    protected function casts(): array
    {
        return [
            'amount'                   => 'decimal:2',
            'commission_rate_snapshot' => 'decimal:2',
            'commission_amount'        => 'decimal:2',
            'net_to_tutor'             => 'decimal:2',
            'held_at'                  => 'datetime',
            'released_at'              => 'datetime',
            'refunded_at'              => 'datetime',
            'status'                   => EscrowStatus::class,
        ];
    }
    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
    public function studentWallet(): BelongsTo { return $this->belongsTo(Wallet::class, 'student_wallet_id'); }
    public function tutorWallet(): BelongsTo { return $this->belongsTo(Wallet::class, 'tutor_wallet_id'); }
}
