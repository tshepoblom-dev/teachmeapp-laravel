<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }
            return redirect()->route('login');
        }

        if (! in_array($user->role->value, $roles, true)) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to perform this action.',
                ], 403);
            }
            // Web: redirect to their own dashboard
            return redirect()->route($this->dashboardRoute($user->role->value))
                ->with('error', 'You do not have permission to access that page.');
        }

        return $next($request);
    }

    private function dashboardRoute(string $role): string
    {
        return match($role) {
            'admin'   => 'admin.dashboard',
            'tutor'   => 'tutor.dashboard',
            'student' => 'student.dashboard',
            default   => 'login',
        };
    }
}