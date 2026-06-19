<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Storage;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? [
                    'id'     => $request->user()->id,
                    'name'   => $request->user()->name,
                    'email'  => $request->user()->email,
                    'role'   => $request->user()->role->value,
                    'avatar' => $request->user()?->profile_photo_path
                        ? Storage::url($request->user()->profile_photo_path)
                        : null,
                    'tier'        => fn () => $request->user()?->isTutor()
                        ? $request->user()->profile?->tutorTier?->name
                        : null,
                    'tier_colour' => fn () => $request->user()?->isTutor()
                        ? $request->user()->profile?->tutorTier?->theme_colour_primary
                        : null,
                ] : null,
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'error'   => $request->session()->get('error'),
            ],
            'status' => $request->session()->get('status'), 
            'pendingKyc' => fn () => $request->user()?->isAdmin()
                ? \App\Models\KycApplication::where('status', 'pending')->count()
                : 0,
            'pendingRequests' => fn () => $request->user()?->isTutor()
                ? \App\Models\Booking::where('tutor_id', $request->user()->id)
                    ->where('status', 'pending')
                    ->count()
                : 0,
            // Unread database notifications for the bell icon (latest 10)
            'unreadNotifications' => fn () => $request->user()
                ? $request->user()->unreadNotifications()
                    ->latest()
                    ->limit(10)
                    ->get()
                    ->map(fn ($n) => [
                        'id'         => $n->id,
                        'type'       => $n->data['type']       ?? 'notification',
                        'message'    => $n->data['message']    ?? '',
                        'booking_id' => $n->data['booking_id'] ?? null,
                        'created_at' => $n->created_at->diffForHumans(),
                    ])
                : [],
            'unreadCount' => fn () => $request->user()
                ? $request->user()->unreadNotifications()->count()
                : 0,
        ]);
    }
}
