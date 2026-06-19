<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class RegisterController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * Handle new user registration.
     *
     * Creates the user, auto-creates Profile + Wallet (via UserObserver),
     * sends email verification notification, and returns a Sanctum token.
     *
     * POST /api/auth/register
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        Log::info('RegisterController: registration attempt', [
            'email' => $request->input('email'),
            'role'  => $request->input('role'),
            'ip'    => $request->ip(),
        ]);

        try {
            $result = $this->authService->register($request->validated());

            Log::info('RegisterController: registration successful', [
                'user_id' => $result['user']->id,
                'email'   => $result['user']->email,
                'role'    => $result['user']->role,
            ]);

            return $this->success(
                data: [
                    'user'       => new UserResource($result['user']->load(['profile', 'wallet'])),
                    'token'      => $result['token'],
                    'token_type' => 'Bearer',
                ],
                message: 'Registration successful. Please verify your email address.',
                status: 201,
            );
        } catch (Throwable $e) {
            Log::error('RegisterController: registration failed', [
                'email' => $request->input('email'),
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
