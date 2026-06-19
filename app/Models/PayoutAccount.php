<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

class PayoutAccount extends Model
{
    protected $fillable = [
        'user_id','account_type','account_holder_name','account_number_encrypted',
        'branch_code','bank_name','gateway_account_id','is_verified','is_default','verified_at',
    ];
    protected $hidden = ['account_number_encrypted'];
    protected function casts(): array
    {
        return ['is_verified' => 'boolean', 'is_default' => 'boolean', 'verified_at' => 'datetime'];
    }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function payoutTransactions(): HasMany { return $this->hasMany(PayoutTransaction::class); }

    public function getAccountNumberAttribute(): string
    {
        return Crypt::decryptString($this->account_number_encrypted);
    }
    public function setAccountNumberAttribute(string $value): void
    {
        $this->account_number_encrypted = Crypt::encryptString($value);
    }
}
