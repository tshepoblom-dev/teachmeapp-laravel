<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Agora App ID
    |--------------------------------------------------------------------------
    | Found in your Agora Console project dashboard.
    | Used to identify your application to the Agora SDK.
    */
    'app_id' => env('AGORA_APP_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Agora App Certificate
    |--------------------------------------------------------------------------
    | Used server-side only for token generation.
    | NEVER expose this in client-side code or API responses.
    */
    'app_certificate' => env('AGORA_APP_CERTIFICATE', ''),

    /*
    |--------------------------------------------------------------------------
    | Recording
    |--------------------------------------------------------------------------
    | Cloud recording configuration (used in Phase 5 session end flow).
    */
    'recording_enabled'       => env('AGORA_RECORDING_ENABLED', false),
    'recording_storage_bucket'=> env('AGORA_RECORDING_BUCKET', ''),
    'recording_storage_key'   => env('AGORA_RECORDING_KEY', ''),
    'recording_storage_secret'=> env('AGORA_RECORDING_SECRET', ''),
];