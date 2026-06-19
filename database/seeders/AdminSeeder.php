<?php

namespace Database\Seeders;

use App\Enums\AccountStatus;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@teachme.local'],
            [
                'name'           => 'Super Admin',
                'email'          => 'admin@teachme.local',
                'password'       => Hash::make('Admin@1234'),
                'role'           => UserRole::Admin,
                'account_status' => AccountStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin account ready:');
        $this->command->info('  Email:    admin@teachme.local');
        $this->command->info('  Password: Admin@1234');
    }
}
