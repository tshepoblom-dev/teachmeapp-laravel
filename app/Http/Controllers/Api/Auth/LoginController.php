<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * Authenticate the user and return a Sanctum API token.
     *
     * Also updates last_login_at and last_login_ip.
     * Rejects suspended/banned accounts before token issuance.
     *
     * POST /api/auth/login
     *
     * @throws ValidationException
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        Log::info('LoginController: login attempt', [
            'email' => $request->input('email'),
            'ip'    => $request->ip(),
        ]);

        try {
            $result = $this->authService->login(
                credentials: $request->only('email', 'password'),
                deviceName: $request->input('device_name', $request->userAgent() ?? 'api'),
                ip: $request->ip(),
            );

            Log::info('LoginController: login successful', [
                'user_id' => $result['user']->id,
                'email'   => $result['user']->email,
                'ip'      => $request->ip(),
            ]);

            return $this->success(
                data: [
                    'user'       => new UserResource($result['user']->load(['profile', 'wallet'])),
                    'token'      => $result['token'],
                    'token_type' => 'Bearer',
                ],
                message: 'Login successful.',
            );
        } catch (ValidationException $e) {
            Log::warning('LoginController: login failed', [
                'email'  => $request->input('email'),
                'ip'     => $request->ip(),
                'reason' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
