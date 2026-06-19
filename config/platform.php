<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Platform Defaults
    |--------------------------------------------------------------------------
    |
    | These are fallback values used when PlatformSettings records are not yet
    | seeded or a setting cannot be found in the database. In production the
    | authoritative values come from the platform_settings table.
    |
    */

    'minimum_hourly_rate'    => env('PLATFORM_MIN_HOURLY_RATE', 50.00),
    'default_commission_rate' => env('PLATFORM_COMMISSION_RATE', 20.00),
    'vat_rate'               => env('PLATFORM_VAT_RATE', 15.00),

    /*
    |--------------------------------------------------------------------------
    | Session / Booking Defaults
    |--------------------------------------------------------------------------
    */

    'session_buffer_minutes'     => 15,
    'grace_period_minutes'       => 10,
    'auto_end_minutes'           => 120,
    'cancellation_lead_time_hours' => 24,
    'cancellation_fee_percent'   => 50,
    'max_future_days_booking'    => 30,

];
