<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin User */
class TutorSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $profile = $this->profile;

        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'bio'            => $profile?->bio,
            'subjects'       => $profile?->subjectRecords->map(fn ($s) => [
                'id' => $s->id, 'name' => $s->name, 'code' => $s->code,
            ]) ?? [],
            'institutions'   => $profile?->institutions->map(fn ($i) => [
                'id' => $i->id, 'name' => $i->name, 'abbreviation' => $i->abbreviation,
            ]) ?? [],
            'hourly_rate'    => (float) ($profile?->hourly_rate ?? 0),
            'average_rating' => (float) ($profile?->average_rating ?? 0),
            'total_reviews'  => (int) ($profile?->total_reviews ?? 0),
            'tier'           => $profile?->tutorTier?->name,
            'tier_colour'    => $profile?->tutorTier?->theme_colour_primary,
            'avatar_url'     => $this->profile_photo_path ? Storage::url($this->profile_photo_path) : null,
        ];
    }
}
