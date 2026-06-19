<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $fillable = ['user_id','balance','escrow_balance','currency'];

    protected function casts(): array
    {
        return [
            'balance'         => 'decimal:2',
            'escrow_balance'  => 'decimal:2',
        ];
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public function transactions(): HasMany { return $this->hasMany(WalletTransaction::class); }

    /** Available balance (not in escrow) */
    public function getAvailableBalance(): float
    {
        return (float) $this->balance;
    }
}
