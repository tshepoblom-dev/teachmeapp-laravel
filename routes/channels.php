<?php

use Illuminate\Support\Facades\Broadcast;

// Register the /broadcasting/auth endpoint (required for private Echo channels)
Broadcast::routes(['middleware' => ['web', 'auth']]);
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/**
 * Private user notification channel.
 *
 * Each authenticated user gets their own private channel:
 *   App.User.{userId}
 *
 * The NotificationBroadcast event broadcasts to this channel whenever
 * a new DatabaseNotification is written for that user.
 */
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * Private session channel.
 *
 * Used by SessionStatusChanged, SessionStarted, and SessionEnded events.
 * Only the tutor or student assigned to the session may subscribe.
 */
Broadcast::channel('session.{sessionId}', function ($user, $sessionId) {
    $session = \App\Models\Session::find($sessionId);

    if (! $session) {
        return false;
    }

    return (int) $user->id === (int) $session->student_id
        || (int) $user->id === (int) $session->tutor_id;
});
