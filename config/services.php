<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'fcm' => [
        'project_id' => env('FCM_PROJECT_ID'),

        /*
         * Resolve the credentials file to an absolute path so it works
         * regardless of the current working directory (local artisan serve,
         * queue workers, horizon, etc.).
         *
         * - If FCM_CREDENTIALS_FILE is already an absolute path → use as-is.
         * - If it is a bare filename or relative path → resolve from base_path().
         * - Default (env var not set) → storage/app/firebase-auth.json.
         */
        'credentials_file' => (function () {
            $raw = env('FIREBASE_CREDENTIALS');
            if (! $raw) {
                return storage_path('app/firebase-auth.json');
            }
            // If the path starts with '/' it is already absolute.
            return str_starts_with($raw, DIRECTORY_SEPARATOR)
                ? $raw
                : base_path($raw);
        })(),
    ],

];
