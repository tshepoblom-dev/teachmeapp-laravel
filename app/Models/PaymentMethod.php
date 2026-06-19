<?php
namespace App\Models;
use App\Enums\PaymentFlow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $fillable = [
        'code','name','description','logo_url','is_active','is_default',
        'display_order','supported_currencies','min_amount','max_amount',
        'payment_flow','settlement_days','config_schema',
    ];
    protected function casts(): array
    {
        return [
            'is_active'             => 'boolean',
            'is_default'            => 'boolean',
            'supported_currencies'  => 'array',
            'config_schema'         => 'array',
            'min_amount'            => 'decimal:2',
            'max_amount'            => 'decimal:2',
            'payment_flow'          => PaymentFlow::class,
        ];
    }
    public function gatewayConfigurations(): HasMany { return $this->hasMany(PaymentGatewayConfiguration::class); }
    public function userPreferences(): HasMany { return $this->hasMany(UserPaymentMethodPreference::class); }
    public function paymentTransactions(): HasMany { return $this->hasMany(PaymentTransaction::class); }
    public function scopeActive($query) { return $query->where('is_active', true)->orderBy('display_order'); }
}
