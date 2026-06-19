<?php
namespace App\Models;
use App\Enums\WalletTransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id','type','amount','direction','balance_before','balance_after',
        'reference','description','metadata','payment_transaction_id',
    ];
    protected function casts(): array
    {
        return [
            'amount'         => 'decimal:2',
            'balance_before' => 'decimal:2',
            'balance_after'  => 'decimal:2',
            'metadata'       => 'array',
            'type'           => WalletTransactionType::class,
        ];
    }
    public function wallet(): BelongsTo { return $this->belongsTo(Wallet::class); }
    public function paymentTransaction(): BelongsTo { return $this->belongsTo(PaymentTransaction::class); }
}
