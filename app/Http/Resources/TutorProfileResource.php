<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin User */
class TutorProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $profile = $this->profile;

        return [
            'id'                       => $this->id,
            'name'                     => $this->name,
            'bio'                      => $profile?->bio,
            'subjects'                 => $profile?->subjectRecords->map(fn ($s) => [
                'id' => $s->id, 'name' => $s->name, 'code' => $s->code, 'faculty' => $s->faculty,
            ]) ?? [],
            'institutions'             => $profile?->institutions->map(fn ($i) => [
                'id' => $i->id, 'name' => $i->name, 'abbreviation' => $i->abbreviation, 'type' => $i->type,
            ]) ?? [],
            'hourly_rate'              => (float) ($profile?->hourly_rate ?? 0),
            'average_rating'           => (float) ($profile?->average_rating ?? 0),
            'total_reviews'            => (int) ($profile?->total_reviews ?? 0),
            'total_sessions'           => (int) ($profile?->total_sessions_hosted ?? 0),
            'education_level'          => $profile?->education_level,
            'years_of_experience'      => $profile?->years_of_experience,
            'teaching_specializations' => $profile?->teaching_specializations ?? [],
            'tier'                     => $profile?->tutorTier?->name,
            'tier_colour'              => $profile?->tutorTier?->theme_colour_primary,
            'is_available'             => (bool) ($profile?->is_available ?? false),
            'avatar_url'               => $this->profile_photo_path ? Storage::url($this->profile_photo_path) : null,
        ];
    }
}
