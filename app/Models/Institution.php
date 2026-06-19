<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institution extends Model
{
    protected $fillable = [
        'name', 'abbreviation', 'type', 'city',
        'province', 'website', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public static function typeLabels(): array
    {
        return [
            'university'                => 'University',
            'university_of_technology'  => 'University of Technology',
            'private_college'           => 'Private College',
            'tvet_college'              => 'TVET College',
            'high_school'               => 'High School',
            'other'                     => 'Other',
        ];
    }

    public function getTypeLabelAttribute(): string
    {
        return self::typeLabels()[$this->type] ?? $this->type;
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}