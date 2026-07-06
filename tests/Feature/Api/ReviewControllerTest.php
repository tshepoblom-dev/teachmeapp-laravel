<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    private function completedBooking(User $student, User $tutor): Booking
    {
        return Booking::create([
            'student_id' => $student->id,
            'tutor_id' => $tutor->id,
            'subject' => 'Maths',
            'scheduled_at' => now()->subDay(),
            'duration_minutes' => 60,
            'hourly_rate_snapshot' => 100,
            'total_amount' => 100,
            'platform_fee_snapshot' => 10,
            'status' => 'completed',
        ]);
    }

    public function test_student_can_review_completed_booking(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $booking = $this->completedBooking($student, $tutor);

        $response = $this->actingAs($student)->postJson("/api/bookings/{$booking->id}/review", [
            'rating' => 5,
            'comment' => 'Great session',
        ]);

        $response->assertCreated()->assertJsonPath('data.rating', 5);
        $this->assertDatabaseHas('reviews', ['booking_id' => $booking->id, 'rating' => 5]);
    }

    public function test_cannot_review_twice(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $booking = $this->completedBooking($student, $tutor);

        $this->actingAs($student)->postJson("/api/bookings/{$booking->id}/review", ['rating' => 5]);
        $response = $this->actingAs($student)->postJson("/api/bookings/{$booking->id}/review", ['rating' => 4]);

        $response->assertStatus(422)->assertJsonPath('success', false);
    }

    public function test_cannot_review_incomplete_booking(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $booking = Booking::create([
            'student_id' => $student->id,
            'tutor_id' => $tutor->id,
            'subject' => 'Maths',
            'scheduled_at' => now()->addDay(),
            'duration_minutes' => 60,
            'hourly_rate_snapshot' => 100,
            'total_amount' => 100,
            'platform_fee_snapshot' => 10,
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($student)->postJson("/api/bookings/{$booking->id}/review", ['rating' => 5]);

        $response->assertStatus(422);
    }

    public function test_tutor_reviews_endpoint_only_returns_visible_reviews(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $booking = $this->completedBooking($student, $tutor);

        $this->actingAs($student)->postJson("/api/bookings/{$booking->id}/review", ['rating' => 4]);

        $response = $this->actingAs($student)->getJson("/api/tutors/{$tutor->id}/reviews");

        $response->assertOk()->assertJsonCount(1, 'data.data');
    }
}
