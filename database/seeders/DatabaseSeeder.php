<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed order matters — tiers and payment methods must exist
     * before any user/profile seeds run.
     */
    public function run(): void
    {
        $this->call([
           // TutorTierSeeder::class,
           // PaymentMethodSeeder::class,
           // PlatformSettingSeeder::class,
         //   AdminSeeder::class,
            DevUserSeeder::class,   // ← add this
         //   InstitutionSubjectSeeder::class, // ← add this
        ]);
    }
}
