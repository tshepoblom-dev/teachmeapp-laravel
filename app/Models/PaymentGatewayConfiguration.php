<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class PaymentGatewayConfiguration extends Model
{
    protected $fillable = ['payment_method_id','environment','config_key','config_value_encrypted','updated_by'];

    public function paymentMethod(): BelongsTo { return $this->belongsTo(PaymentMethod::class); }
    public function updatedBy(): BelongsTo { return $this->belongsTo(User::class, 'updated_by'); }

    /** Decrypt the config value transparently */
    public function getConfigValueAttribute(): string
    {
        return Crypt::decryptString($this->config_value_encrypted);
    }

    /** Encrypt on set */
    public function setConfigValueAttribute(string $value): void
    {
        $this->config_value_encrypted = Crypt::encryptString($value);
    }
}
