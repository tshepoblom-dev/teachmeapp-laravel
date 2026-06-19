<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    protected $fillable = [
        'name', 'code', 'faculty', 'institution_id', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    /** Display label — "MAT101 – Mathematics (UCT)" or just "Mathematics" */
    public function getDisplayNameAttribute(): string
    {
        $parts = array_filter([
            $this->code,
            $this->name,
            $this->institution?->abbreviation ? "({$this->institution->abbreviation})" : null,
        ]);
        return implode(' – ', array_slice($parts, 0, 2))
            . ($this->institution?->abbreviation ? " ({$this->institution->abbreviation})" : '');
    }
}