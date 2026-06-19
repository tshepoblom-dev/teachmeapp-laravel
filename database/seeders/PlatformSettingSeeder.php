<?php

namespace Database\Seeders;

use App\Models\PlatformSetting;
use Illuminate\Database\Seeder;

class PlatformSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── Rates ────────────────────────────────────────────────────────
            ['group' => 'rates', 'key' => 'minimum_hourly_rate',   'value' => '100.00',    'data_type' => 'decimal', 'label' => 'Minimum Hourly Rate (ZAR)',          'is_public' => true],
            ['group' => 'rates', 'key' => 'default_hourly_rate',   'value' => '100.00',   'data_type' => 'decimal', 'label' => 'Suggested Hourly Rate (ZAR)',          'is_public' => true],
            ['group' => 'rates', 'key' => 'default_commission_rate','value' => '50.00',   'data_type' => 'decimal', 'label' => 'Default Commission Rate % (pre-tier)', 'is_public' => false],
            ['group' => 'rates', 'key' => 'vat_rate',              'value' => '15.00',    'data_type' => 'decimal', 'label' => 'VAT Rate %',                           'is_public' => true],

            // ── Sessions ─────────────────────────────────────────────────────
            ['group' => 'sessions', 'key' => 'duration_options',        'value' => '[60,90,120,180]', 'data_type' => 'json',    'label' => 'Allowed Session Durations (minutes)', 'is_public' => true],
            ['group' => 'sessions', 'key' => 'grace_period_minutes',    'value' => '10',             'data_type' => 'integer', 'label' => 'Late Join Grace Period (minutes)',     'is_public' => true],
            ['group' => 'sessions', 'key' => 'auto_end_minutes',        'value' => '180',            'data_type' => 'integer', 'label' => 'Max Session Length (minutes)',         'is_public' => false],
            ['group' => 'sessions', 'key' => 'session_buffer_minutes',  'value' => '0',             'data_type' => 'integer', 'label' => 'Gap Between Bookings (minutes)',       'is_public' => false],

            // ── Bookings ─────────────────────────────────────────────────────
            ['group' => 'bookings', 'key' => 'cancellation_lead_time_hours', 'value' => '24', 'data_type' => 'integer', 'label' => 'Free Cancellation Lead Time (hours)', 'is_public' => true],
            ['group' => 'bookings', 'key' => 'cancellation_fee_percent',     'value' => '50', 'data_type' => 'integer', 'label' => 'Late Cancellation Fee %',             'is_public' => true],

            // ── Payments ─────────────────────────────────────────────────────
            ['group' => 'payments', 'key' => 'default_payment_method',    'value' => 'payfast',                    'data_type' => 'string', 'label' => 'Default Gateway Code',      'is_public' => true],
            ['group' => 'payments', 'key' => 'available_payment_methods', 'value' => '["payfast","wallet_balance"]','data_type' => 'json',   'label' => 'Enabled Gateway Codes',      'is_public' => true],

            // ── KYC ──────────────────────────────────────────────────────────
            ['group' => 'kyc', 'key' => 'require_kyc_for_tutors',  'value' => 'true',                          'data_type' => 'boolean', 'label' => 'Enforce KYC for Tutors',    'is_public' => false],
            ['group' => 'kyc', 'key' => 'allowed_document_types',  'value' => '["national_id","passport"]',    'data_type' => 'json',    'label' => 'Accepted ID Document Types', 'is_public' => true],

            // ── Features ─────────────────────────────────────────────────────
            ['group' => 'features', 'key' => 'enable_emergency_sessions',    'value' => 'true', 'data_type' => 'boolean', 'label' => 'Allow Instant Bookings',          'is_public' => true],
            ['group' => 'features', 'key' => 'max_future_days_booking',      'value' => '30',   'data_type' => 'integer', 'label' => 'Max Advance Booking Days',        'is_public' => true],
            ['group' => 'features', 'key' => 'max_active_sessions_per_tutor','value' => '5',    'data_type' => 'integer', 'label' => 'Concurrent Session Limit (Tutor)','is_public' => false],

            // ── Notifications ────────────────────────────────────────────────
            ['group' => 'notifications', 'key' => 'reminder_hours_before_session', 'value' => '[1,3,24]',                  'data_type' => 'json',    'label' => 'Session Reminder Schedule (hours before)',                                       'is_public' => false],
            // These are informational mirrors of the NOTIFICATION_CHANNELS .env var.
            // The authoritative toggle is the .env value; these are shown in admin for visibility.
            ['group' => 'notifications', 'key' => 'enabled_channels',              'value' => 'database,mail,fcm',         'data_type' => 'string',  'label' => 'Enabled Channels (matches NOTIFICATION_CHANNELS in .env)',                       'is_public' => false],
        ];

        foreach ($settings as $setting) {
            PlatformSetting::updateOrCreate(
                ['group' => $setting['group'], 'key' => $setting['key']],
                array_merge($setting, [
                    'description'  => null,
                    'is_encrypted' => false,
                    'updated_by'   => null,
                ])
            );
        }

        $this->command->info(count($settings) . ' platform settings seeded.');
    }
}
