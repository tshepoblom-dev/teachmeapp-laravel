<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php', 
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
        $middleware->web(append: [
                \App\Http\Middleware\HandleInertiaRequests::class,
                \App\Http\Middleware\EnsureConsentGiven::class,
            ]);
        $middleware->alias([
            'check.account.status' => \App\Http\Middleware\CheckAccountStatus::class,
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
            'role' => \App\Http\Middleware\HandleRole::class,
            'consent' => \App\Http\Middleware\EnsureConsentGiven::class,
        ]);

        // Exempt payment webhooks from CSRF verification.
        // Gateways (PayFast ITN, Ozow) call these server-to-server without a CSRF token.
        $middleware->validateCsrfTokens(except: [
            'api/payment/webhook/*',
            'broadcasting/auth',   // ← 
        ]);
         $middleware->trustProxies(at: '*');  
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Unauthenticated — 401 JSON
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                    'code'    => 'unauthenticated',
                ], 401);
            }
        });

        // Validation errors — 422 JSON
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors'  => $e->errors(),
                ], 422);
            }
        });

        // 404 — JSON for API routes
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found.',
                    'code'    => 'not_found',
                ], 404);
            }
        });

    })->create();
