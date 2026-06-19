<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    use ApiResponse;

    /**
     * Revoke the current access token.
     *
     * POST /api/auth/logout
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        Log::info('LogoutController: user logged out', [
            'user_id' => $user->id,
            'ip'      => $request->ip(),
        ]);

        $request->user()->currentAccessToken()->delete();

        return $this->success(message: 'Logged out successfully.');
    }
}
