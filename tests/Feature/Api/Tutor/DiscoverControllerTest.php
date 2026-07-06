<?php

namespace Tests\Feature\Api\Tutor;

use App\Models\Institution;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscoverControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_search_tutors_by_subject_and_institution(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $institution = Institution::create(['name' => 'Test Uni', 'abbreviation' => 'TU', 'type' => 'university', 'is_active' => true]);
        $subject = Subject::create(['name' => 'Maths', 'code' => 'MAT101', 'is_active' => true]);

        $tutor = User::factory()->create(['role' => 'tutor']);
        $tutor->profile->update(['is_available' => true, 'hourly_rate' => 100, 'average_rating' => 4.5]);
        $tutor->profile->institutions()->attach($institution->id);
        $tutor->profile->subjectRecords()->attach($subject->id);

        $unrelatedTutor = User::factory()->create(['role' => 'tutor']);
        $unrelatedTutor->profile->update(['is_available' => true]);

        $response = $this->actingAs($student)->getJson("/api/tutors?subject_id={$subject->id}&institution_id={$institution->id}");

        $response->assertOk()->assertJsonCount(1, 'data.data');
        $this->assertSame($tutor->id, $response->json('data.data.0.id'));
    }

    public function test_unavailable_tutors_excluded(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        // profile.is_available defaults to false

        $response = $this->actingAs($student)->getJson('/api/tutors');

        $response->assertOk()->assertJsonCount(0, 'data.data');
    }

    public function test_show_returns_404_for_non_tutor_user(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $otherStudent = User::factory()->create(['role' => 'student']);

        $this->actingAs($student)->getJson("/api/tutors/{$otherStudent->id}")->assertNotFound();
    }

    public function test_show_includes_reviews_and_availability(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);

        $response = $this->actingAs($student)->getJson("/api/tutors/{$tutor->id}");

        $response->assertOk()
            ->assertJsonStructure(['data' => ['tutor', 'availability', 'reviews']])
            ->assertJsonPath('data.tutor.id', $tutor->id);
    }
}
