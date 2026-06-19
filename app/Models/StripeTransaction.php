<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StripeTransaction extends Model
{
    protected $fillable = [
        'payment_transaction_id','wallet_id','stripe_payment_intent_id','stripe_customer_id',
        'payment_method_id_stripe','amount','currency','fee_amount','net_amount','status','webhook_payload',
    ];
    protected function casts(): array
    {
        return ['webhook_payload' => 'array', 'amount' => 'decimal:2', 'fee_amount' => 'decimal:2', 'net_amount' => 'decimal:2'];
    }
    public function paymentTransaction(): BelongsTo { return $this->belongsTo(PaymentTransaction::class); }
    public function wallet(): BelongsTo { return $this->belongsTo(Wallet::class); }
}
