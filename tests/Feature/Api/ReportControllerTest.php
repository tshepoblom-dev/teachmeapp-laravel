<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\EscrowTransaction;
use App\Models\Session;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    private function activeSession(User $student, User $tutor): Session
    {
        $booking = Booking::create([
            'student_id' => $student->id,
            'tutor_id' => $tutor->id,
            'subject' => 'Maths',
            'scheduled_at' => now(),
            'duration_minutes' => 60,
            'hourly_rate_snapshot' => 100,
            'total_amount' => 100,
            'platform_fee_snapshot' => 10,
            'status' => 'in_progress',
        ]);

        EscrowTransaction::create([
            'booking_id' => $booking->id,
            'student_wallet_id' => $student->wallet->id,
            'tutor_wallet_id' => $tutor->wallet->id,
            'amount' => 100,
            'status' => 'held',
            'held_at' => now(),
        ]);

        return Session::create([
            'booking_id' => $booking->id,
            'agora_channel_name' => 'channel-' . $booking->id,
            'agora_uid_student' => 1001,
            'agora_uid_tutor' => 1002,
            'status' => 'active',
            'started_at' => now(),
        ]);
    }

    public function test_participant_can_submit_report_with_continue_session(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $session = $this->activeSession($student, $tutor);

        $response = $this->actingAs($student)->postJson("/api/sessions/{$session->id}/report", [
            'reason' => 'Inappropriate behaviour',
            'action_taken' => 'continue_session',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('reports', ['session_id' => $session->id, 'reporter_id' => $student->id]);
        $session->refresh();
        $this->assertSame('active', $session->status->value);
    }

    public function test_report_with_end_session_action_ends_the_session(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $session = $this->activeSession($student, $tutor);

        $response = $this->actingAs($student)->postJson("/api/sessions/{$session->id}/report", [
            'reason' => 'Ending early',
            'action_taken' => 'end_session',
        ]);

        $response->assertCreated();
        $session->refresh();
        $this->assertSame('ended', $session->status->value);
    }

    public function test_non_participant_forbidden(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $outsider = User::factory()->create(['role' => 'student']);
        $session = $this->activeSession($student, $tutor);

        $response = $this->actingAs($outsider)->postJson("/api/sessions/{$session->id}/report", [
            'reason' => 'Test',
            'action_taken' => 'continue_session',
        ]);

        $response->assertStatus(403);
    }
}
