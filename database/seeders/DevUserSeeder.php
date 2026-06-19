<?php

namespace Database\Seeders;

use App\Enums\AccountStatus;
use App\Enums\KycStatus;
use App\Enums\UserRole;
use App\Models\Profile;
use App\Models\TutorTier;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevUserSeeder extends Seeder
{
    public function run(): void
    {
        $standardTier = TutorTier::where('slug', 'bronze')->first();
        $proTier      = TutorTier::where('slug', 'silver')->first();
        $eliteTier    = TutorTier::where('slug', 'gold')->first();

        // ── Students ──────────────────────────────────────────────────────
        $students = [
            ['name' => 'Alice Student',   'email' => 'student@teachme.local'],
            ['name' => 'Bongani Learner', 'email' => 'student2@teachme.local'],
        ];

        foreach ($students as $data) {
            $user = User::updateOrCreate(['email' => $data['email']], [
                'name'              => $data['name'],
                'password'          => Hash::make('Student@1234'),
                'role'              => UserRole::Student,
                'account_status'    => AccountStatus::Active,
                'email_verified_at' => now(),
            ]);

            Profile::updateOrCreate(['user_id' => $user->id], [
                'phone_number'      => '+27600000001',
                'timezone'          => 'Africa/Johannesburg',
                'kyc_status'        => KycStatus::NotSubmitted,
            ]);

            Wallet::updateOrCreate(['user_id' => $user->id], [
                'balance'         => 500.00,
                'escrow_balance'  => 0.00,
                'currency'        => 'ZAR',
            ]);
        }

        // ── Tutors ────────────────────────────────────────────────────────
        $tutors = [
            [
                'name'     => 'Thabo Tutor',
                'email'    => 'tutor@teachme.local',
                'tier'     => $standardTier,
                'subjects' => ['Mathematics', 'Physical Science'],
                'bio'      => 'Passionate Maths and Science tutor with 3 years of experience helping Grade 10–12 students.',
                'kyc'      => KycStatus::Approved,
                'status'   => AccountStatus::Active,
            ],
            [
                'name'     => 'Priya Pro',
                'email'    => 'tutor-pro@teachme.local',
                'tier'     => $proTier,
                'subjects' => ['English', 'Afrikaans', 'History'],
                'bio'      => 'Silver-tier language specialist. 30+ sessions completed with a 4.8 average rating.',
                'kyc'      => KycStatus::Approved,
                'status'   => AccountStatus::Active,
            ],
            [
                'name'     => 'Dr. Elite Mokoena',
                'email'    => 'tutor-elite@teachme.local',
                'tier'     => $eliteTier,
                'subjects' => ['Mathematics', 'Computer Science', 'Accounting'],
                'bio'      => 'Gold-tier tutor with a BSc Honours. 100+ sessions, dedicated to results.',
                'kyc'      => KycStatus::Approved,
                'status'   => AccountStatus::Active,
            ],
            [
                'name'     => 'Pending Pete',
                'email'    => 'tutor-pending@teachme.local',
                'tier'     => null,
                'subjects' => ['Geography', 'Life Sciences'],
                'bio'      => 'Recently registered, KYC pending review.',
                'kyc'      => KycStatus::Pending,
                'status'   => AccountStatus::PendingKyc,
            ],
        ];

        foreach ($tutors as $data) {
            $user = User::updateOrCreate(['email' => $data['email']], [
                'name'              => $data['name'],
                'password'          => Hash::make('Tutor@1234'),
                'role'              => UserRole::Tutor,
                'account_status'    => $data['status'],
                'email_verified_at' => now(),
            ]);

            Profile::updateOrCreate(['user_id' => $user->id], [
                'bio'                      => $data['bio'],
                'subjects'                 => $data['subjects'],
                'hourly_rate'              => 100.00,
                'is_available'             => true,
                'kyc_status'               => $data['kyc'],
                'tutor_tier_id'            => $data['tier']?->id,
                'tier_assigned_at'         => $data['tier'] ? now() : null,
                'phone_number'             => '+27600000002',
                'timezone'                 => 'Africa/Johannesburg',
                'years_of_experience'      => 3,
                'education_level'          => 'Bachelor\'s Degree',
                'teaching_specializations' => $data['subjects'],
                'id_verified'              => $data['kyc'] === KycStatus::Approved,
            ]);

            Wallet::updateOrCreate(['user_id' => $user->id], [
                'balance'        => 250.00,
                'escrow_balance' => 0.00,
                'currency'       => 'ZAR',
            ]);
        }

        // ── Summary ───────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('Dev users seeded — all passwords shown below:');
        $this->command->info('');
        $this->command->info('  STUDENTS (password: Student@1234)');
        $this->command->info('    student@teachme.local        Alice Student        — R500 wallet');
        $this->command->info('    student2@teachme.local       Bongani Learner      — R500 wallet');
        $this->command->info('');
        $this->command->info('  TUTORS (password: Tutor@1234)');
        $this->command->info('    tutor@teachme.local          Thabo Tutor          — Bronze tier, KYC approved');
        $this->command->info('    tutor-pro@teachme.local      Priya Pro            — Silver tier, KYC approved');
        $this->command->info('    tutor-elite@teachme.local    Dr. Elite Mokoena    — Gold tier, KYC approved');
        $this->command->info('    tutor-pending@teachme.local  Pending Pete         — No tier, KYC pending');
        $this->command->info('');
        $this->command->info('  ADMIN (password: Admin@1234)');
        $this->command->info('    admin@teachme.local          Super Admin');
        $this->command->info('');
    }
}