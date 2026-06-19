<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayfastTransaction extends Model
{
    protected $fillable = [
        'payment_transaction_id','wallet_id','pf_payment_id','m_payment_id',
        'amount_gross','amount_fee','amount_net','item_name','payment_status',
        'itn_verified','itn_payload','signature',
    ];
    protected function casts(): array
    {
        return ['itn_payload' => 'array', 'itn_verified' => 'boolean', 'amount_gross' => 'decimal:2', 'amount_fee' => 'decimal:2', 'amount_net' => 'decimal:2'];
    }
    public function paymentTransaction(): BelongsTo { return $this->belongsTo(PaymentTransaction::class); }
    public function wallet(): BelongsTo { return $this->belongsTo(Wallet::class); }
}
