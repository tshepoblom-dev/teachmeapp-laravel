<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class PlatformSetting extends Model
{
    protected $fillable = ['group','key','value','data_type','label','description','is_public','is_encrypted','updated_by'];
    protected function casts(): array { return ['is_public' => 'boolean', 'is_encrypted' => 'boolean']; }

    public function updatedBy(): BelongsTo { return $this->belongsTo(User::class, 'updated_by'); }

    /** Return value cast to its declared data_type */
    public function getCastValueAttribute(): mixed
    {
        $raw = $this->is_encrypted ? Crypt::decryptString($this->value) : $this->value;
        return match ($this->data_type) {
            'integer' => (int) $raw,
            'decimal' => (float) $raw,
            'boolean' => filter_var($raw, FILTER_VALIDATE_BOOLEAN),
            'json'    => json_decode($raw, true),
            default   => $raw,
        };
    }

    public function scopePublic($query) { return $query->where('is_public', true); }
    public function scopeGroup($query, string $group) { return $query->where('group', $group); }
    public static function getValue(string $group, string $key, mixed $default = null): mixed
    {
        $setting = static::where('group', $group)->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
