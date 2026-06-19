<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TierResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isAdmin = $request->user()?->role->value === 'admin';

        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'slug'               => $this->slug,
            'sessions_threshold' => $this->sessions_threshold,

            // Commission rates — shown to admins in full,
            // shown to tutors so they understand their earnings
            'commission_rate'            => (float) $this->commission_rate,
            'bonus_rate_above_threshold' => $this->bonus_rate_above_threshold
                ? (float) $this->bonus_rate_above_threshold
                : null,

            // Theme — used by Flutter app for tier badge rendering
            'theme' => [
                'colour_primary'   => '#' . $this->theme_colour_primary,
                'colour_secondary' => '#' . $this->theme_colour_secondary,
                'badge_icon_url'   => $this->badge_icon_url,
            ],

            'features'      => $this->features ?? [],
            'is_active'     => (bool) $this->is_active,
            'display_order' => $this->display_order,

            // Admin-only fields
            'tutor_count' => $this->when(
                $isAdmin,
                fn () => $this->whenCounted('profiles', fn () => $this->profiles_count)
            ),

            'created_at' => $this->when(
                $isAdmin,
                fn () => $this->created_at?->toIso8601String()
            ),

            'updated_at' => $this->when(
                $isAdmin,
                fn () => $this->updated_at?->toIso8601String()
            ),
        ];
    }
}