<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * Return the authenticated user with profile and wallet.
     *
     * GET /api/user
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load(['profile.tutorTier', 'wallet']);

        return $this->success(
            data: new UserResource($user),
        );
    }

    /**
     * Update the authenticated user's name and/or profile fields.
     *
     * PUT /api/user/profile
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Minimum hourly rate guard for tutors
        if ($user->isTutor() && isset($data['hourly_rate'])) {
            $minRate = (float) config('platform.minimum_hourly_rate', 50);
            if ((float) $data['hourly_rate'] < $minRate) {
                throw ValidationException::withMessages([
                    'hourly_rate' => ["Hourly rate must be at least R{$minRate}."],
                ]);
            }
        }

        $user = $this->authService->updateProfile($user, $data);

        return $this->success(
            data: new UserResource($user->load(['profile.tutorTier', 'wallet'])),
            message: 'Profile updated successfully.',
        );
    }

    /**
     * Change password while authenticated.
     *
     * PUT /api/user/password
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => [
                'required',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()->uncompromised(),
            ],
        ]);

        if (! Hash::check($validated['current_password'], $request->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Revoke all other tokens (force re-login on other devices)
        $request->user()->tokens()
            ->where('id', '!=', $request->user()->currentAccessToken()->id)
            ->delete();

        return $this->success(message: 'Password changed successfully.');
    }
}
