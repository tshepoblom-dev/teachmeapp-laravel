<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
    use ApiResponse;

    /**
     * Return the current email verification status.
     *
     * GET /api/email/verify/status
     */
    public function status(Request $request): JsonResponse
    {
        return $this->success(data: [
            'email_verified' => $request->user()->hasVerifiedEmail(),
            'email'          => $request->user()->email,
        ]);
    }

    /**
     * Re-send the email verification notification.
     *
     * POST /api/email/verification-notification
     */
    public function send(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->success(message: 'Email is already verified.');
        }

        $user->sendEmailVerificationNotification();

        Log::info('EmailVerificationController: verification email resent', [
            'user_id' => $user->id,
            'email'   => $user->email,
        ]);

        return $this->success(message: 'Verification link sent.');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * GET /api/email/verify/{id}/{hash}  (signed URL)
     *
     * Note: Laravel's EmailVerificationRequest handles the signed URL check
     * and user resolution automatically.
     */
    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->success(message: 'Email already verified.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            Log::info('EmailVerificationController: email verified', [
                'user_id' => $user->id,
                'email'   => $user->email,
            ]);
        }

        return $this->success(message: 'Email verified successfully.');
    }
}
