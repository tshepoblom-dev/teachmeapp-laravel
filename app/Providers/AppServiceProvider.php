<?php

namespace App\Providers;

use App\Observers\NotificationObserver;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        bcscale(2);
        // Wire real-time WebSocket delivery for every database notification
        // written anywhere in the application — no changes needed per-notification.
        DatabaseNotification::observe(NotificationObserver::class);
        User::observe(UserObserver::class); // ← ADD THIS
    }
}
