<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class InstitutionSubjectSeeder extends Seeder
{
    public function run(): void
    {
        // ── Institutions ────────────────────────────────────────────────────
        $institutions = [
            ['name' => 'University of Cape Town',            'abbreviation' => 'UCT',   'type' => 'university',               'city' => 'Cape Town',     'province' => 'Western Cape'],
            ['name' => 'Stellenbosch University',            'abbreviation' => 'SU',    'type' => 'university',               'city' => 'Stellenbosch',  'province' => 'Western Cape'],
            ['name' => 'University of the Witwatersrand',    'abbreviation' => 'Wits',  'type' => 'university',               'city' => 'Johannesburg',  'province' => 'Gauteng'],
            ['name' => 'University of Pretoria',             'abbreviation' => 'UP',    'type' => 'university',               'city' => 'Pretoria',      'province' => 'Gauteng'],
            ['name' => 'University of KwaZulu-Natal',        'abbreviation' => 'UKZN',  'type' => 'university',               'city' => 'Durban',        'province' => 'KwaZulu-Natal'],
            ['name' => 'Cape Peninsula University of Technology', 'abbreviation' => 'CPUT', 'type' => 'university_of_technology', 'city' => 'Cape Town', 'province' => 'Western Cape'],
            ['name' => 'Tshwane University of Technology',   'abbreviation' => 'TUT',   'type' => 'university_of_technology', 'city' => 'Pretoria',      'province' => 'Gauteng'],
            ['name' => 'Durban University of Technology',    'abbreviation' => 'DUT',   'type' => 'university_of_technology', 'city' => 'Durban',        'province' => 'KwaZulu-Natal'],
            ['name' => 'Varsity College',                    'abbreviation' => 'VC',    'type' => 'private_college',          'city' => 'Multiple',      'province' => null],
            ['name' => 'Rosebank College',                   'abbreviation' => 'RC',    'type' => 'private_college',          'city' => 'Multiple',      'province' => null],
            ['name' => 'False Bay TVET College',             'abbreviation' => 'FBTC',  'type' => 'tvet_college',             'city' => 'Cape Town',     'province' => 'Western Cape'],
            ['name' => 'Northlink TVET College',             'abbreviation' => 'NLC',   'type' => 'tvet_college',             'city' => 'Cape Town',     'province' => 'Western Cape'],
        ];

        foreach ($institutions as $order => $data) {
            Institution::firstOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['sort_order' => $order, 'is_active' => true])
            );
        }

        // ── Universal subjects (not institution-specific) ─────────────────
        $universal = [
            ['name' => 'Mathematics',              'faculty' => 'Science & Engineering'],
            ['name' => 'Applied Mathematics',      'faculty' => 'Science & Engineering'],
            ['name' => 'Statistics',               'faculty' => 'Science & Engineering'],
            ['name' => 'Physics',                  'faculty' => 'Science & Engineering'],
            ['name' => 'Chemistry',                'faculty' => 'Science & Engineering'],
            ['name' => 'Biology',                  'faculty' => 'Science & Engineering'],
            ['name' => 'Computer Science',         'faculty' => 'Computing & IT'],
            ['name' => 'Information Technology',   'faculty' => 'Computing & IT'],
            ['name' => 'Accounting',               'faculty' => 'Commerce & Finance'],
            ['name' => 'Economics',                'faculty' => 'Commerce & Finance'],
            ['name' => 'Business Management',      'faculty' => 'Commerce & Finance'],
            ['name' => 'English',                  'faculty' => 'Humanities'],
            ['name' => 'Afrikaans',                'faculty' => 'Humanities'],
            ['name' => 'History',                  'faculty' => 'Humanities'],
            ['name' => 'Geography',                'faculty' => 'Humanities'],
        ];

        foreach ($universal as $order => $data) {
            Subject::firstOrCreate(
                ['name' => $data['name'], 'institution_id' => null],
                array_merge($data, ['sort_order' => $order, 'is_active' => true])
            );
        }
    }
}