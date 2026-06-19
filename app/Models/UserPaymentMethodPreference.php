<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPaymentMethodPreference extends Model
{
    protected $fillable = ['user_id','payment_method_id','is_enabled','is_default','saved_details','gateway_customer_id'];
    protected function casts(): array
    {
        return ['is_enabled' => 'boolean', 'is_default' => 'boolean', 'saved_details' => 'array'];
    }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function paymentMethod(): BelongsTo { return $this->belongsTo(PaymentMethod::class); }
}
