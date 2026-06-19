<?php

namespace App\Models;

use App\Enums\KycStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'bio', 'subjects', 'hourly_rate', 'is_available',
        'average_rating', 'total_reviews', 'total_sessions_hosted',
        'total_sessions_attended', 'id_verified', 'phone_number',
        'timezone', 'language_preference', 'teaching_specializations',
        'education_level', 'years_of_experience', 'tutor_tier_id',
        'tier_assigned_at', 'kyc_status', 'kyc_application_id',
    ];

    protected function casts(): array
    {
        return [
            'subjects'                 => 'array',
            'teaching_specializations' => 'array',
            'is_available'             => 'boolean',
            'id_verified'              => 'boolean',
            'hourly_rate'              => 'decimal:2',
            'average_rating'           => 'decimal:2',
            'tier_assigned_at'         => 'datetime',
            'kyc_status'               => KycStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tutorTier(): BelongsTo
    {
        return $this->belongsTo(TutorTier::class);
    }

    public function kycApplication(): BelongsTo
    {
        return $this->belongsTo(KycApplication::class);
    }
    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(Institution::class, 'profile_institutions');
    }

    public function subjectRecords(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'profile_subjects');
    }
}
