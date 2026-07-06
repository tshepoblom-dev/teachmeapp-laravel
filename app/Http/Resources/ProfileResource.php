<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'bio'                      => $this->bio,
            'phone_number'             => $this->phone_number,
            'timezone'                 => $this->timezone,
            'language_preference'      => $this->language_preference,
            'kyc_status'               => $this->kyc_status->value,
            'id_verified'              => $this->id_verified,
            'is_available'             => $this->is_available,

            // Tutor-specific fields (null for students)
            'subjects'                 => $this->subjects,
            'hourly_rate'              => $this->hourly_rate ? (float) $this->hourly_rate : null,
            'average_rating'           => $this->average_rating ? (float) $this->average_rating : null,
            'total_reviews'            => $this->total_reviews,
            'total_sessions_hosted'    => $this->total_sessions_hosted,
            'total_sessions_attended'  => $this->total_sessions_attended,
            'teaching_specializations' => $this->teaching_specializations,
            'education_level'          => $this->education_level,
            'years_of_experience'      => $this->years_of_experience,
            'institutions'             => $this->whenLoaded('institutions', fn () =>
                $this->institutions->map(fn ($i) => [
                    'id' => $i->id, 'name' => $i->name, 'abbreviation' => $i->abbreviation,
                ])
            ),
            'subject_records'          => $this->whenLoaded('subjectRecords', fn () =>
                $this->subjectRecords->map(fn ($s) => [
                    'id' => $s->id, 'name' => $s->name, 'code' => $s->code,
                ])
            ),

            // Tier info (null until promoted)
            'tier' => $this->whenLoaded('tutorTier', fn () =>
                $this->tutorTier ? [
                    'id'    => $this->tutorTier->id,
                    'name'  => $this->tutorTier->name,
                    'slug'  => $this->tutorTier->slug,
                    'badge_icon_url'         => $this->tutorTier->badge_icon_url,
                    'theme_colour_primary'   => $this->tutorTier->theme_colour_primary,
                    'theme_colour_secondary' => $this->tutorTier->theme_colour_secondary,
                    'commission_rate'        => (float) $this->tutorTier->commission_rate,
                ] : null
            ),
        ];
    }
}
