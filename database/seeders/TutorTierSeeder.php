<?php

namespace Database\Seeders;

use App\Models\TutorTier;
use Illuminate\Database\Seeder;

class TutorTierSeeder extends Seeder
{
    public function run(): void
    {
        $tiers = [
            [
                'name'                       => 'Bronze',
                'slug'                       => 'bronze',
                'sessions_threshold'         => 0,
                'commission_rate'            => 20.00,
                'bonus_rate_above_threshold' => null,
                'theme_colour_primary'       => '#CD7F32',
                'theme_colour_secondary'     => '#A0522D',
                'badge_icon_url'             => null,
                'features'                   => json_encode([]),
                'is_active'                  => true,
                'display_order'              => 1,
            ],
            [
                'name'                       => 'Silver',
                'slug'                       => 'silver',
                'sessions_threshold'         => 25,
                'commission_rate'            => 15.00,
                'bonus_rate_above_threshold' => null,
                'theme_colour_primary'       => '#C0C0C0',
                'theme_colour_secondary'     => '#A8A9AD',
                'badge_icon_url'             => null,
                'features'                   => json_encode(['priority_support']),
                'is_active'                  => true,
                'display_order'              => 2,
            ],
            [
                'name'                       => 'Gold',
                'slug'                       => 'gold',
                'sessions_threshold'         => 75,
                'commission_rate'            => 10.00,
                'bonus_rate_above_threshold' => 2.00,
                'theme_colour_primary'       => '#FFD700',
                'theme_colour_secondary'     => '#DAA520',
                'badge_icon_url'             => null,
                'features'                   => json_encode(['priority_support', 'featured_listing', 'dedicated_account_manager']),
                'is_active'                  => true,
                'display_order'              => 3,
            ],
        ];

        foreach ($tiers as $tier) {
            TutorTier::updateOrCreate(['slug' => $tier['slug']], $tier);
        }

        $this->command->info('Tutor tiers seeded: Bronze (20%), Silver (15%), Gold (10%)');
    }
}
