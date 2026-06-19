<?php

namespace App\Services;

use App\Enums\AccountStatus;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Register a new user.
     *
     * Wraps creation in a DB transaction. Profile + Wallet are created
     * automatically by UserObserver inside the same transaction.
     *
     * @param  array{name: string, email: string, password: string, role: string, timezone?: string}  $data
     * @return array{user: User, token: string}
     */
    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name'           => $data['name'],
                'email'          => $data['email'],
                'password'       => Hash::make($data['password']),
                'role'           => $data['role'],
                'account_status' => AccountStatus::Active,
                // POPIA consent captured at registration
                'consent_accepted_at' => now(),
                'consent_ip'          => request()->ip(),
                'consent_user_agent'  => substr((string) request()->userAgent(), 0, 500),
            ]);

            // Apply optional timezone from registration form to the auto-created profile
            if (! empty($data['timezone'])) {
                $user->profile()->update(['timezone' => $data['timezone']]);
            }

            // Send email verification
            $user->sendEmailVerificationNotification();

            AuditLog::create([
                'user_id'     => $user->id,
                'action'      => 'user_registered',
                'target_type' => 'user',
                'target_id'   => $user->id,
                'new_values'  => [
                    'role'                => $data['role'],
                    'email'               => $data['email'],
                    'consent_accepted_at' => now()->toIso8601String(),
                    'consent_ip'          => request()->ip(),
                    'consent_user_agent'  => substr((string) request()->userAgent(), 0, 500),
                ],
            ]);

            $token = $user->createToken('registration')->plainTextToken;

            Log::info('User registered', ['user_id' => $user->id, 'role' => $data['role']]);

            return ['user' => $user, 'token' => $token];
        });
    }

    /**
     * Authenticate a user by email + password and return a Sanctum token.
     *
     * @param  array{email: string, password: string}  $credentials
     * @return array{user: User, token: string}
     *
     * @throws ValidationException
     */
    public function login(array $credentials, string $deviceName, ?string $ip = null): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Account status checks — suspended/banned cannot receive tokens
        if ($user->account_status === \App\Enums\AccountStatus::Banned) {
            throw ValidationException::withMessages([
                'email' => ['This account has been permanently banned.'],
            ]);
        }

        if ($user->isSuspended()) {
            throw ValidationException::withMessages([
                'email' => [
                    'This account is temporarily suspended until ' .
                    $user->suspended_until?->toFormattedDateString() . '.',
                ],
            ]);
        }

        // Update last login metadata
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
        ]);

        AuditLog::create([
            'user_id'     => $user->id,
            'action'      => 'user_login',
            'target_type' => 'user',
            'target_id'   => $user->id,
            'ip_address'  => $ip,
        ]);

        $token = $user->createToken($deviceName)->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    /**
     * Update user name and/or profile fields.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateProfile(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            // User-level fields
            if (isset($data['name'])) {
                $user->update(['name' => $data['name']]);
            }

            // Profile-level fields — filter to only profile columns
            $profileFields = [
                'bio', 'phone_number', 'timezone', 'language_preference',
                'subjects', 'hourly_rate', 'is_available',
                'teaching_specializations', 'education_level', 'years_of_experience',
            ];

            $profileData = array_intersect_key($data, array_flip($profileFields));

            // Non-tutors cannot set tutor-only fields
            if (! $user->isTutor()) {
                unset(
                    $profileData['subjects'],
                    $profileData['hourly_rate'],
                    $profileData['is_available'],
                    $profileData['teaching_specializations'],
                    $profileData['education_level'],
                    $profileData['years_of_experience'],
                );
            }

            if (! empty($profileData)) {
                $user->profile()->update($profileData);
            }

            Log::info('AuthService: profile updated', [
                'user_id'        => $user->id,
                'user_fields'    => isset($data['name']) ? ['name'] : [],
                'profile_fields' => array_keys($profileData),
            ]);

            return $user->fresh();
        });
    }
}
