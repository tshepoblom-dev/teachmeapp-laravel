<?php

namespace Tests\Feature\Api;

use App\Models\Institution;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_tutor_can_update_institutions_and_subjects(): void
    {
        $tutor = User::factory()->create(['role' => 'tutor']);
        $institution = Institution::create(['name' => 'Test Uni', 'abbreviation' => 'TU', 'type' => 'university', 'is_active' => true]);
        $subject = Subject::create(['name' => 'Maths', 'code' => 'MAT101', 'is_active' => true]);

        $response = $this->actingAs($tutor)->putJson('/api/user/profile', [
            'institution_ids' => [$institution->id],
            'subject_ids' => [$subject->id],
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('profile_institutions', ['institution_id' => $institution->id]);
        $this->assertDatabaseHas('profile_subjects', ['subject_id' => $subject->id]);
        $response->assertJsonPath('data.profile.institutions.0.id', $institution->id);
        $response->assertJsonPath('data.profile.subject_records.0.id', $subject->id);
    }

    public function test_student_cannot_set_tutor_only_institution_fields(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $institution = Institution::create(['name' => 'Test Uni', 'abbreviation' => 'TU', 'type' => 'university', 'is_active' => true]);

        $this->actingAs($student)->putJson('/api/user/profile', [
            'institution_ids' => [$institution->id],
        ])->assertOk();

        $this->assertDatabaseMissing('profile_institutions', ['institution_id' => $institution->id]);
    }

    public function test_avatar_upload_replaces_existing_and_deletes_old_file(): void
    {
        Storage::fake('public');
        $user = User::factory()->create(['role' => 'student']);
        $user->forceFill(['profile_photo_path' => 'avatars/old.jpg'])->save();
        Storage::disk('public')->put('avatars/old.jpg', 'old-content');

        $newFile = UploadedFile::fake()->image('new.jpg');

        $response = $this->actingAs($user)->postJson('/api/user/profile/avatar', ['avatar' => $newFile]);

        $response->assertOk();
        Storage::disk('public')->assertMissing('avatars/old.jpg');
        $this->assertNotSame('avatars/old.jpg', $user->fresh()->profile_photo_path);
    }

    public function test_avatar_rejects_non_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create(['role' => 'student']);

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $this->actingAs($user)->postJson('/api/user/profile/avatar', ['avatar' => $file])->assertStatus(422);
    }
}
