<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TutorTier extends Model
{
    protected $fillable = [
        'name','slug','sessions_threshold','commission_rate',
        'bonus_rate_above_threshold','theme_colour_primary','theme_colour_secondary',
        'badge_icon_url','features','is_active','display_order',
    ];

    protected function casts(): array
    {
        return [
            'features'   => 'array',
            'is_active'  => 'boolean',
            'commission_rate' => 'decimal:2',
        ];
    }

    public function profiles(): HasMany { return $this->hasMany(Profile::class, 'tutor_tier_id'); }

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeOrdered($query) { return $query->orderBy('display_order'); }
}
