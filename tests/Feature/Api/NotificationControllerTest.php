<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    private function makeNotification(User $user, ?\DateTimeInterface $readAt = null): string
    {
        $id = (string) Str::uuid();

        DB::table('notifications')->insert([
            'id' => $id,
            'type' => 'App\\Notifications\\BookingAcceptedNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'data' => json_encode(['type' => 'booking_accepted', 'message' => 'Test']),
            'read_at' => $readAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $id;
    }

    public function test_user_can_list_own_notifications_paginated(): void
    {
        $user = User::factory()->create();
        $this->makeNotification($user);
        $this->makeNotification($user);

        $response = $this->actingAs($user)->getJson('/api/notifications');

        $response->assertOk()->assertJsonCount(2, 'data.data');
    }

    public function test_user_cannot_mark_another_users_notification_as_read(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $id = $this->makeNotification($other);

        $this->actingAs($user)->postJson("/api/notifications/{$id}/read")->assertNotFound();
    }

    public function test_mark_all_read_clears_unread_count(): void
    {
        $user = User::factory()->create();
        $this->makeNotification($user);
        $this->makeNotification($user);

        $this->actingAs($user)->postJson('/api/notifications/read-all')->assertOk();

        $this->assertSame(0, $user->unreadNotifications()->count());
    }
}
