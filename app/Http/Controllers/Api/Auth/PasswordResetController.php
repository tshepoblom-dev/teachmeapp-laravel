<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Traits\ApiResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    use ApiResponse;

    /**
     * Send a password reset link to the given email.
     *
     * POST /api/auth/forgot-password
     */
    public function sendLink(ForgotPasswordRequest $request): JsonResponse
    {
        $email = $request->input('email');

        Log::info('PasswordResetController: reset link requested', [
            'email' => $email,
            'ip'    => $request->ip(),
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status !== Password::RESET_LINK_SENT) {
            Log::warning('PasswordResetController: reset link send failed', [
                'email'  => $email,
                'status' => $status,
            ]);
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        Log::info('PasswordResetController: reset link sent', ['email' => $email]);

        return $this->success(message: 'Password reset link sent to your email address.');
    }

    /**
     * Reset the user's password using the token from the email link.
     *
     * POST /api/auth/reset-password
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $email = $request->input('email');

        Log::info('PasswordResetController: password reset attempt', [
            'email' => $email,
            'ip'    => $request->ip(),
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Revoke all existing tokens so the old session cannot be reused
                $user->tokens()->delete();

                Log::info('PasswordResetController: password reset successful', [
                    'user_id' => $user->id,
                    'email'   => $user->email,
                ]);

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            Log::warning('PasswordResetController: password reset failed', [
                'email'  => $email,
                'status' => $status,
            ]);
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return $this->success(message: 'Password has been reset successfully. Please log in.');
    }
}
