<?php

/**
 * CORS configuration.
 *
 * On cPanel shared hosting, the broadcast auth endpoint (/broadcasting/auth)
 * is called from the browser (Pusher SDK) as a same-origin XHR, so CORS is
 * not strictly required. However, some cPanel servers add unexpected
 * intermediary headers; this config ensures the auth endpoint always responds
 * correctly.
 *
 * The paths list intentionally includes 'broadcasting/auth' and 'sanctum/csrf-cookie'.
 */
return [

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'broadcasting/auth',
        'login',
        'logout',
    ],

    'allowed_methods' => ['*'],

    // In production this should list only your actual domain.
    // Using APP_URL keeps it tied to your single .env value.
    'allowed_origins' => [env('APP_URL', 'http://localhost')],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Must be true for Sanctum stateful authentication to work.
    // Sends the session/XSRF cookies on cross-origin requests.
    'supports_credentials' => true,

];
