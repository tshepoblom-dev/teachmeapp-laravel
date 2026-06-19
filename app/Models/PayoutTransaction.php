<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayoutTransaction extends Model
{
    protected $fillable = [
        'user_id','payout_account_id','amount','status','reference',
        'external_payout_id','failure_reason','processed_at',
    ];
    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'processed_at' => 'datetime'];
    }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function payoutAccount(): BelongsTo { return $this->belongsTo(PayoutAccount::class); }
}
