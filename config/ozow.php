<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ozow Configuration
    |--------------------------------------------------------------------------
    |
    | Fallback values for fresh installs. Production credentials are managed
    | via payment_gateway_configurations (encrypted DB rows).
    |
    */

    'site_code'   => env('OZOW_SITE_CODE',   ''),
    'private_key' => env('OZOW_PRIVATE_KEY', ''),
    'api_key'     => env('OZOW_API_KEY',     ''),
    'sandbox'     => env('OZOW_SANDBOX',      true),

    'api_base_url' => 'https://api.ozow.com',
];
