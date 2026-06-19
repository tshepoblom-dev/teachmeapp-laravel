<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayFast Configuration
    |--------------------------------------------------------------------------
    |
    | These values are FALLBACKS used when the database gateway configuration
    | has not been seeded yet (e.g., fresh install, CI environments).
    |
    | In production, all credentials live in payment_gateway_configurations
    | (encrypted) and are injected at runtime by PaymentGatewayServiceProvider.
    |
    */

    'merchant_id'  => env('PAYFAST_MERCHANT_ID',  '10000100'),
    'merchant_key' => env('PAYFAST_MERCHANT_KEY',  '46f0cd694581a'),
    'passphrase'   => env('PAYFAST_PASSPHRASE',    ''),
    'sandbox'      => env('PAYFAST_SANDBOX',        true),

    'return_url'   => env('PAYFAST_RETURN_URL',    env('APP_URL') . '/api/payment/callback/payfast'),
    'cancel_url'   => env('PAYFAST_CANCEL_URL',    env('APP_URL') . '/payment/cancelled'),
    'notify_url'   => env('PAYFAST_NOTIFY_URL',    env('APP_URL') . '/api/payment/webhook/payfast'),

    'process_url_sandbox'    => 'https://sandbox.payfast.co.za/eng/process',
    'process_url_production' => 'https://www.payfast.co.za/eng/process',
    'validate_url_sandbox'   => 'https://sandbox.payfast.co.za/eng/query/validate',
    'validate_url_production'=> 'https://www.payfast.co.za/eng/query/validate',
];
