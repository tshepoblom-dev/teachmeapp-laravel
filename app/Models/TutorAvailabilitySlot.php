<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TutorAvailabilitySlot extends Model
{
    protected $fillable = [
        'tutor_id','day_of_week','start_time','end_time',
        'is_recurring','valid_from','valid_until','is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_recurring' => 'boolean',
            'is_active'    => 'boolean',
            'valid_from'   => 'date',
            'valid_until'  => 'date',
        ];
    }

    public function tutor(): BelongsTo { return $this->belongsTo(User::class, 'tutor_id'); }

    public function scopeActive($query) { return $query->where('is_active', true); }
}
