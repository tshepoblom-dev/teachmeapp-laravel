<?php

namespace App\Http\Middleware;

use App\Enums\AccountStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        $isApi = $request->is('api/*') || $request->expectsJson();

        switch ($user->account_status) {
            case AccountStatus::Banned:
                if ($isApi) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your account has been permanently banned.',
                        'code'    => 'account_banned',
                    ], 403);
                }
                auth()->logout();
                $request->session()->invalidate();
                return redirect()->route('login')->withErrors([
                    'email' => 'Your account has been permanently banned.',
                ]);

            case AccountStatus::Suspended:
                // Auto-lift expired suspensions
                if ($user->suspended_until && $user->suspended_until->isPast()) {
                    $user->update([
                        'account_status'    => AccountStatus::Active,
                        'suspended_until'   => null,
                        'suspension_reason' => null,
                    ]);
                    break;
                }
                if ($isApi) {
                    return response()->json([
                        'success'           => false,
                        'message'           => 'Your account is temporarily suspended.',
                        'code'              => 'account_suspended',
                        'suspended_until'   => $user->suspended_until?->toIso8601String(),
                        'suspension_reason' => $user->suspension_reason,
                    ], 403);
                }
                auth()->logout();
                $request->session()->invalidate();
                return redirect()->route('login')->withErrors([
                    'email' => 'Your account is temporarily suspended until ' .
                               $user->suspended_until?->toFormattedDateString() . '.',
                ]);

            case AccountStatus::PendingKyc:
                if ($isApi) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your account is pending KYC verification.',
                        'code'    => 'pending_kyc',
                    ], 403);
                }
                // Allow through on web — KYC status shown in-app
                break;
        }

        return $next($request);
    }
}