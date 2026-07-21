<?php

namespace App\Models;

use App\Enums\AccountStatus;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'account_status',
        'suspended_until',
        'suspension_reason',
        'profile_photo_path',
        'last_login_at',
        'last_login_ip',
        'default_payment_method_id',
        'fcm_token', 
        'consent_accepted_at',
        'consent_ip',
        'consent_user_agent',            
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'last_login_at'        => 'datetime',
            'suspended_until'      => 'datetime',
            'role'                 => UserRole::class,
            'account_status'       => AccountStatus::class,
            'two_factor_secret'    => 'encrypted',
            'consent_accepted_at' => 'datetime',
            'consent_ip' => 'string',
            'consent_user_agent' => 'string',
        ];
    }

    // ─── Accessors ───────────────────────────────────────────────────────────

    /**
     * Public URL for the user's avatar. Referenced by BookingResource,
     * ChatMessageResource, etc. so tutors and students can see each other's
     * photo outside of their own profile pages.
     */
    protected function profilePhotoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->profile_photo_path ? Storage::disk('public')->url($this->profile_photo_path) : null,
        );
    }

    // ─── Role helpers ────────────────────────────────────────────────────────

    public function isAdmin(): bool    { return $this->role === UserRole::Admin; }
    public function isTutor(): bool    { return $this->role === UserRole::Tutor; }
    public function isStudent(): bool  { return $this->role === UserRole::Student; }

    public function isActive(): bool
    {
        return $this->account_status === AccountStatus::Active;
    }

    public function isSuspended(): bool
    {
        if ($this->account_status !== AccountStatus::Suspended) return false;
        // Auto-lift suspension if expired
        if ($this->suspended_until && $this->suspended_until->isPast()) return false;
        return true;
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function availabilitySlots(): HasMany
    {
        return $this->hasMany(TutorAvailabilitySlot::class, 'tutor_id');
    }

    /** Bookings where this user is the student */
    public function bookingsAsStudent(): HasMany
    {
        return $this->hasMany(Booking::class, 'student_id');
    }

    /** Bookings where this user is the tutor */
    public function bookingsAsTutor(): HasMany
    {
        return $this->hasMany(Booking::class, 'tutor_id');
    }

    public function reviewsGiven(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function reportsSubmitted(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function reportsAgainst(): HasMany
    {
        return $this->hasMany(Report::class, 'reported_id');
    }

    public function kycApplications(): HasMany
    {
        return $this->hasMany(KycApplication::class);
    }

    public function payoutAccounts(): HasMany
    {
        return $this->hasMany(PayoutAccount::class);
    }

    public function paymentMethodPreferences(): HasMany
    {
        return $this->hasMany(UserPaymentMethodPreference::class);
    }

    public function defaultPaymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'default_payment_method_id');
    }

    /** Guardian relationships (for students under 18) */
    public function guardians(): HasMany
    {
        return $this->hasMany(ParentUserGuardian::class, 'student_id');
    }

    /** Students being guarded (for guardian accounts) */
    public function guardianFor(): HasMany
    {
        return $this->hasMany(ParentUserGuardian::class, 'guardian_id');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeTutors($query)
    {
        return $query->where('role', UserRole::Tutor->value);
    }

    public function scopeStudents($query)
    {
        return $query->where('role', UserRole::Student->value);
    }

    public function scopeActive($query)
    {
        return $query->where('account_status', AccountStatus::Active->value);
    }
    /**
     * Route FCM notifications to this user's registered device token.
     * Returns null when the user has no token — the FCM channel will skip sending.
     */
    public function routeNotificationForFcm(): ?string
    {
        return $this->fcm_token;
    }

    /**
     * Use our branded verification email instead of Laravel's default Markdown one.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new \App\Notifications\VerifyEmailNotification);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    public function hasGivenConsent(): bool
    {
        return $this->consent_accepted_at !== null;
    }
}
