<?php
namespace App\Models;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'user_id','wallet_id','booking_id','payment_method_id','amount','currency',
        'status','gateway_transaction_id','gateway_status','metadata',
        'completed_at','refunded_at','refund_amount',
    ];
    protected function casts(): array
    {
        return [
            'amount'        => 'decimal:2',
            'refund_amount' => 'decimal:2',
            'metadata'      => 'array',
            'completed_at'  => 'datetime',
            'refunded_at'   => 'datetime',
            'status'        => PaymentStatus::class,
        ];
    }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function wallet(): BelongsTo { return $this->belongsTo(Wallet::class); }
    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
    public function paymentMethod(): BelongsTo { return $this->belongsTo(PaymentMethod::class); }
    public function payfastTransaction(): HasOne { return $this->hasOne(PayfastTransaction::class); }
    public function stripeTransaction(): HasOne { return $this->hasOne(StripeTransaction::class); }
}
