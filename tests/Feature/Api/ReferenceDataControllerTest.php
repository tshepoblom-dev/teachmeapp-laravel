<?php

namespace Tests\Feature\Api;

use App\Models\Institution;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReferenceDataControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_institutions_list_excludes_inactive(): void
    {
        $user = User::factory()->create();
        Institution::create(['name' => 'Active Uni', 'is_active' => true]);
        Institution::create(['name' => 'Inactive Uni', 'is_active' => false]);

        $response = $this->actingAs($user)->getJson('/api/institutions');

        $response->assertOk()->assertJsonCount(1, 'data');
        $this->assertSame('Active Uni', $response->json('data.0.name'));
    }

    public function test_subjects_filtered_by_institution_includes_universal_subjects(): void
    {
        $user = User::factory()->create();
        $institution = Institution::create(['name' => 'Uni A', 'is_active' => true]);
        $otherInstitution = Institution::create(['name' => 'Uni B', 'is_active' => true]);

        Subject::create(['name' => 'Specific to A', 'institution_id' => $institution->id, 'is_active' => true]);
        Subject::create(['name' => 'Specific to B', 'institution_id' => $otherInstitution->id, 'is_active' => true]);
        Subject::create(['name' => 'Universal', 'institution_id' => null, 'is_active' => true]);

        $response = $this->actingAs($user)->getJson("/api/subjects?institution_id={$institution->id}");

        $response->assertOk()->assertJsonCount(2, 'data');
        $names = collect($response->json('data'))->pluck('name')->sort()->values()->all();
        $this->assertSame(['Specific to A', 'Universal'], $names);
    }
}
