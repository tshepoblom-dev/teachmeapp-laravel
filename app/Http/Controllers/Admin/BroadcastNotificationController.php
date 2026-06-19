<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminBroadcastNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use Inertia\Response;

class BroadcastNotificationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Notifications/Broadcast', [
            'recipientCounts' => [
                'all'     => User::count(),
                'student' => User::where('role', 'student')->count(),
                'tutor'   => User::where('role', 'tutor')->count(),
                'admin'   => User::where('role', 'admin')->count(),
            ],
        ]);
    }

    /**
     * Live user search for the specific-users picker.
     * Returns JSON — not an Inertia response.
     */
    public function searchUsers(Request $request): JsonResponse
    {
        $q = $request->string('q')->toString();

        $users = User::when($q, fn ($query) =>
                $query->where(fn ($s) =>
                    $s->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                )
            )
            ->orderBy('name')
            ->limit(30)
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }

    public function send(Request $request): RedirectResponse
    {
        $request->validate([
            'target'       => ['required', 'in:all,role,specific'],
            'roles'        => ['required_if:target,role', 'array'],
            'roles.*'      => ['in:student,tutor,admin'],
            'user_ids'     => ['required_if:target,specific', 'array'],
            'user_ids.*'   => ['integer', 'exists:users,id'],
            'channels'     => ['required', 'array', 'min:1'],
            'channels.*'   => ['in:database,mail,fcm'],
            'title'        => ['required', 'string', 'max:100'],
            'body'         => ['required', 'string', 'max:1000'],
        ]);

        $channels = $request->input('channels');
        $title    = $request->input('title');
        $body     = $request->input('body');

        $notification = new AdminBroadcastNotification($title, $body, $channels);

        match ($request->input('target')) {
            'all' => User::chunk(100, fn ($chunk) =>
                Notification::send($chunk, $notification)
            ),

            'role' => User::whereIn('role', $request->input('roles', []))
                ->chunk(100, fn ($chunk) =>
                    Notification::send($chunk, $notification)
                ),

            'specific' => Notification::send(
                User::findMany($request->input('user_ids', [])),
                $notification
            ),
        };

        return back()->with('success', 'Notification queued and on its way.');
    }
}
