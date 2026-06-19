<?php

namespace App\Services;

use App\Models\PlatformSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class PlatformSettingsService
{
    private const CACHE_TTL = 300; // 5 minutes

    /**
     * Get a setting value, cast to the correct type.
     */
    public function get(string $group, string $key, mixed $default = null): mixed
    {
        $setting = Cache::remember(
            "platform_setting:{$group}:{$key}",
            self::CACHE_TTL,
            fn () => PlatformSetting::where('group', $group)->where('key', $key)->first()
        );

        if (! $setting) {
            return $default;
        }

        $raw = $setting->is_encrypted
            ? Crypt::decryptString($setting->value)
            : $setting->value;

        return $this->cast($raw, $setting->data_type);
    }

    /**
     * Set a setting value (admin use). Clears cache.
     */
    public function set(string $group, string $key, mixed $value, int $updatedBy = null): void
    {
        $setting = PlatformSetting::where('group', $group)->where('key', $key)->firstOrFail();

        $stored = $setting->is_encrypted
            ? Crypt::encryptString((string) $value)
            : (string) $value;

        $setting->update([
            'value'      => $stored,
            'updated_by' => $updatedBy,
        ]);

        Cache::forget("platform_setting:{$group}:{$key}");
    }

    /**
     * Get all settings in a group, keyed by setting key.
     */
    public function group(string $group): array
    {
        $settings = PlatformSetting::where('group', $group)->get();

        return $settings->mapWithKeys(function ($setting) {
            $raw = $setting->is_encrypted
                ? Crypt::decryptString($setting->value)
                : $setting->value;

            return [$setting->key => $this->cast($raw, $setting->data_type)];
        })->toArray();
    }

    /**
     * Get all public-facing settings (safe to expose via API).
     */
    public function publicSettings(): array
    {
        return Cache::remember('platform_settings:public', self::CACHE_TTL, function () {
            return PlatformSetting::where('is_public', true)
                ->get()
                ->groupBy('group')
                ->map(fn ($group) => $group->mapWithKeys(fn ($s) => [
                    $s->key => $this->cast($s->value, $s->data_type),
                ]))
                ->toArray();
        });
    }

    /**
     * Flush the entire settings cache.
     */
    public function flushCache(): void
    {
        Cache::flush(); // Scoped flush would be preferred if using tagged cache
    }

    private function cast(string $raw, string $type): mixed
    {
        return match ($type) {
            'integer' => (int) $raw,
            'decimal' => (float) $raw,
            'boolean' => filter_var($raw, FILTER_VALIDATE_BOOLEAN),
            'json'    => json_decode($raw, true),
            default   => $raw,
        };
    }
}