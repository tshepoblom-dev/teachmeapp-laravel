<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class StudentProfileController extends Controller
{
    public function edit(Request $request): Response
    {
        $user    = $request->user()->load('profile');
        $profile = $user->profile;

        return Inertia::render('Student/Profile/Edit', [
          // In edit(), change the 'user' key to:
            'user' => [
                'name'       => $user->name,
                'email'      => $user->email,
                'avatar_url' => $user->profile_photo_path
                    ? Storage::url($user->profile_photo_path)
                    : null,
            ],
            'profile' => [
                'bio'                     => $profile?->bio,
                'phone_number'            => $profile?->phone_number,
                'timezone'                => $profile?->timezone ?? 'Africa/Johannesburg',
                'language_preference'     => $profile?->language_preference ?? 'en',
                'total_sessions_attended' => (int) ($profile?->total_sessions_attended ?? 0),
                'total_reviews'           => (int) ($profile?->total_reviews ?? 0),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'                => ['required', 'string', 'max:255'],
            'bio'                 => ['nullable', 'string', 'max:1000'],
            'phone_number'        => ['nullable', 'string', 'max:20'],
            'timezone'            => ['nullable', 'string', 'max:50'],
            'language_preference' => ['nullable', 'string', 'max:10'],
        ]);

        $request->user()->update(['name' => $data['name']]);

        $request->user()->profile()->updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'bio'                 => $data['bio'],
                'phone_number'        => $data['phone_number'],
                'timezone'            => $data['timezone'] ?? 'Africa/Johannesburg',
                'language_preference' => $data['language_preference'] ?? 'en',
            ]
        );

        return back()->with('success', 'Profile updated successfully.');
    }

    public function uploadAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->forceFill(['profile_photo_path' => $path])->save();
        $user->refresh();

        return redirect()->route('student.profile.edit')->with('success', 'Profile photo updated.');
    }
}