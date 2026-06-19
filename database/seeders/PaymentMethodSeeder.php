<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'code'                 => 'wallet_balance',
                'name'                 => 'Wallet Balance',
                'description'          => 'Pay using your platform wallet balance.',
                'logo_url'             => null,
                'is_active'            => true,
                'is_default'           => false,
                'display_order'        => 1,
                'supported_currencies' => json_encode(['ZAR']),
                'min_amount'           => 1.00,
                'max_amount'           => null,
                'payment_flow'         => 'wallet',
                'settlement_days'      => 0,
                'config_schema'        => null,
            ],
            [
                'code'                 => 'payfast',
                'name'                 => 'PayFast',
                'description'          => 'Pay securely via PayFast — supports EFT, credit card, and instant EFT.',
                'logo_url'             => null,
                'is_active'            => true,
                'is_default'           => true,
                'display_order'        => 2,
                'supported_currencies' => json_encode(['ZAR']),
                'min_amount'           => 5.00,
                'max_amount'           => null,
                'payment_flow'         => 'redirect',
                'settlement_days'      => 1,
                'config_schema'        => json_encode([
                    'fields' => [
                        ['key' => 'merchant_id',  'label' => 'Merchant ID',  'type' => 'string',  'required' => true],
                        ['key' => 'merchant_key', 'label' => 'Merchant Key', 'type' => 'password','required' => true],
                        ['key' => 'passphrase',   'label' => 'Passphrase',   'type' => 'password','required' => false],
                        ['key' => 'sandbox',      'label' => 'Sandbox Mode', 'type' => 'boolean', 'required' => false, 'default' => true],
                    ],
                ]),
            ],
            [
                'code'                 => 'ozow',
                'name'                 => 'Ozow (Instant EFT)',
                'description'          => 'Pay instantly via Ozow bank-to-bank transfer — no credit card needed.',
                'logo_url'             => null,
                'is_active'            => false,
                'is_default'           => false,
                'display_order'        => 3,
                'supported_currencies' => json_encode(['ZAR']),
                'min_amount'           => 10.00,
                'max_amount'           => null,
                'payment_flow'         => 'redirect',
                'settlement_days'      => 1,
                'config_schema'        => json_encode([
                    'fields' => [
                        ['key' => 'site_code',   'label' => 'Site Code',   'type' => 'string',  'required' => true],
                        ['key' => 'private_key', 'label' => 'Private Key', 'type' => 'password','required' => true],
                        ['key' => 'api_key',     'label' => 'API Key',     'type' => 'password','required' => true],
                        ['key' => 'sandbox',     'label' => 'Sandbox Mode','type' => 'boolean', 'required' => false, 'default' => true],
                    ],
                ]),
            ],
            [
                'code'                 => 'stripe',
                'name'                 => 'Credit / Debit Card (Stripe)',
                'description'          => 'Pay with any major credit or debit card via Stripe.',
                'logo_url'             => null,
                'is_active'            => false,
                'is_default'           => false,
                'display_order'        => 4,
                'supported_currencies' => json_encode(['ZAR', 'USD', 'EUR', 'GBP']),
                'min_amount'           => 1.00,
                'max_amount'           => null,
                'payment_flow'         => 'direct',
                'settlement_days'      => 2,
                'config_schema'        => json_encode([
                    'fields' => [
                        ['key' => 'publishable_key', 'label' => 'Publishable Key', 'type' => 'string',  'required' => true],
                        ['key' => 'secret_key',      'label' => 'Secret Key',      'type' => 'password','required' => true],
                        ['key' => 'webhook_secret',  'label' => 'Webhook Secret',  'type' => 'password','required' => true],
                        ['key' => 'sandbox',         'label' => 'Sandbox Mode',    'type' => 'boolean', 'required' => false, 'default' => true],
                    ],
                ]),
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(['code' => $method['code']], $method);
        }

        $this->command->info('Payment methods seeded: Wallet Balance, PayFast (active), Ozow (inactive), Stripe (inactive)');
    }
}
