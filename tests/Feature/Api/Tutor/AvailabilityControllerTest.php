<?php

namespace Tests\Feature\Api\Tutor;

use App\Models\TutorAvailabilitySlot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvailabilityControllerTest extends TestCase
{
    use RefreshDatabase;

    private function slotPayload(array $overrides = []): array
    {
        return array_merge([
            'day_of_week' => 1,
            'start_time' => '09:00',
            'end_time' => '10:00',
            'is_recurring' => true,
        ], $overrides);
    }

    public function test_tutor_can_crud_own_slots(): void
    {
        $tutor = User::factory()->create(['role' => 'tutor']);

        $store = $this->actingAs($tutor)->postJson('/api/tutor/availability', $this->slotPayload());
        $store->assertCreated();
        $slotId = $store->json('data.id');

        $this->actingAs($tutor)->getJson('/api/tutor/availability')->assertOk()->assertJsonCount(1, 'data');

        $update = $this->actingAs($tutor)->putJson("/api/tutor/availability/{$slotId}", $this->slotPayload(['start_time' => '11:00', 'end_time' => '12:00']));
        $update->assertOk()->assertJsonPath('data.start_time', '11:00');

        $toggle = $this->actingAs($tutor)->patchJson("/api/tutor/availability/{$slotId}/toggle");
        $toggle->assertOk()->assertJsonPath('data.is_active', false);

        $this->actingAs($tutor)->deleteJson("/api/tutor/availability/{$slotId}")->assertOk();
        $this->assertDatabaseMissing('tutor_availability_slots', ['id' => $slotId]);
    }

    public function test_tutor_cannot_update_other_tutors_slot(): void
    {
        $owner = User::factory()->create(['role' => 'tutor']);
        $other = User::factory()->create(['role' => 'tutor']);

        $slot = TutorAvailabilitySlot::create([
            'tutor_id' => $owner->id,
            'day_of_week' => 1,
            'start_time' => '09:00',
            'end_time' => '10:00',
            'is_recurring' => true,
            'is_active' => true,
        ]);

        $this->actingAs($other)
            ->putJson("/api/tutor/availability/{$slot->id}", $this->slotPayload())
            ->assertForbidden();
    }

    public function test_overlap_rejected(): void
    {
        $tutor = User::factory()->create(['role' => 'tutor']);

        $this->actingAs($tutor)->postJson('/api/tutor/availability', $this->slotPayload())->assertCreated();

        $response = $this->actingAs($tutor)->postJson('/api/tutor/availability', $this->slotPayload(['start_time' => '09:30', 'end_time' => '10:30']));

        $response->assertStatus(422)->assertJsonPath('success', false);
    }

    public function test_bulk_store_reports_created_and_skipped_counts(): void
    {
        $tutor = User::factory()->create(['role' => 'tutor']);

        $response = $this->actingAs($tutor)->postJson('/api/tutor/availability/bulk', [
            'slots' => [
                $this->slotPayload(['day_of_week' => 1]),
                $this->slotPayload(['day_of_week' => 1, 'start_time' => '09:30', 'end_time' => '10:30']),
                $this->slotPayload(['day_of_week' => 2]),
            ],
        ]);

        $response->assertOk()
            ->assertJsonPath('data.created', 2)
            ->assertJsonPath('data.skipped', 1);
    }

    public function test_public_slots_route_untouched(): void
    {
        $tutor = User::factory()->create(['role' => 'tutor']);
        $student = User::factory()->create(['role' => 'student']);

        TutorAvailabilitySlot::create([
            'tutor_id' => $tutor->id,
            'day_of_week' => 1,
            'start_time' => '09:00',
            'end_time' => '10:00',
            'is_recurring' => true,
            'is_active' => true,
        ]);

        $response = $this->actingAs($student)->getJson("/api/tutors/{$tutor->id}/availability");

        $response->assertOk()->assertJsonStructure(['data']);
        $this->assertArrayNotHasKey('success', $response->json());
    }
}
