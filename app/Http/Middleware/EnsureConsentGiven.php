<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureConsentGiven
{
    /**
     * Routes that are always reachable even without consent.
     * Prevents redirect loops.
     */
    private const EXEMPT = [
        'legal.privacy',
        'legal.terms',
        'consent.show',
        'consent.store',
        'logout',
        'verification.notice',
        'verification.verify',
        'verification.send',
    ];
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->hasGivenConsent()) {
            return $next($request);
        }

        // Skip exempt named routes
        foreach (self::EXEMPT as $name) {
            if ($request->routeIs($name)) {
                return $next($request);
            }
        }
        // Inertia requests get a redirect, not a JSON 403
        return redirect()->route('consent.show');
    }
}
