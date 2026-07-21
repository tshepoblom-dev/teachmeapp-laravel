<?php

namespace App\Listeners;

use App\Enums\UserRole;
use App\Events\UserRegistered;
use App\Models\User;
use App\Notifications\NewUserRegisteredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendNewUserRegisteredNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    /**
     * Dispatch only after the wrapping DB transaction commits so the new
     * user row is guaranteed to exist before admins are notified.
     */
    public bool $afterCommit = true;

    public function handle(UserRegistered $event): void
    {
        try {
            $notification = new NewUserRegisteredNotification($event->user);

            User::where('role', UserRole::Admin)
                ->chunk(100, fn ($admins) => Notification::send($admins, $notification));

            Log::info('UserRegistered admin notification dispatched', [
                'user_id' => $event->user->id,
                'role'    => $event->user->role->value,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send UserRegistered admin notification', [
                'user_id' => $event->user->id,
                'error'   => $e->getMessage(),
            ]);

            // Do not rethrow — notification failure must never affect registration flow
        }
    }
}
