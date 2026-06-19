<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;

class TutorProfileController extends Controller
{
    public function edit(Request $request): Response
    {
        $user    = $request->user()->load('profile.tutorTier', 'profile.institutions', 'profile.subjectRecords');
        $profile = $user->profile;

        return Inertia::render('Tutor/Profile/Edit', [
            'profile' => [
                'bio'                      => $profile?->bio,
                'institution_ids'          => $profile?->institutions->pluck('id') ?? [],
                'subject_ids'              => $profile?->subjectRecords->pluck('id') ?? [],
                'is_available'             => (bool) ($profile?->is_available ?? false),
                'phone_number'             => $profile?->phone_number,
                'timezone'                 => $profile?->timezone ?? 'Africa/Johannesburg',
                'teaching_specializations' => $profile?->teaching_specializations ?? [],
                'education_level'          => $profile?->education_level,
                'years_of_experience'      => $profile?->years_of_experience,
                'language_preference'      => $profile?->language_preference ?? 'en',
            ],
           // In edit(), change the 'user' key to:
            'user' => [
                'name'       => $user->name,
                'email'      => $user->email,
                'avatar_url' => $user->profile_photo_path
                    ? Storage::url($user->profile_photo_path)
                    : null,
            ],
            'institutions' => Institution::active()->orderBy('sort_order')->orderBy('name')
                ->get(['id', 'name', 'abbreviation', 'type']),
            'subjects'     => Subject::where('is_active', true)->orderBy('sort_order')->orderBy('name')
                ->with('institution:id,abbreviation')
                ->get(['id', 'name', 'code', 'faculty', 'institution_id']),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'                     => ['required', 'string', 'max:255'],
            'bio'                      => ['nullable', 'string', 'max:2000'],
            'institution_ids'          => ['nullable', 'array'],
            'institution_ids.*'        => ['integer', 'exists:institutions,id'],
            'subject_ids'              => ['nullable', 'array'],
            'subject_ids.*'            => ['integer', 'exists:subjects,id'],
            'is_available'             => ['boolean'],
            'phone_number'             => ['nullable', 'string', 'max:20'],
            'timezone'                 => ['nullable', 'string', 'max:50'],
            'teaching_specializations' => ['nullable', 'array'],
            'education_level'          => ['nullable', 'string', 'max:100'],
            'years_of_experience'      => ['nullable', 'integer', 'min:0', 'max:60'],
            'language_preference'      => ['nullable', 'string', 'max:10'],
        ]);

        $request->user()->update(['name' => $data['name']]);

        $profile = $request->user()->profile()->updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'bio'                      => $data['bio'],
                'is_available'             => $data['is_available'] ?? false,
                'phone_number'             => $data['phone_number'],
                'timezone'                 => $data['timezone'] ?? 'Africa/Johannesburg',
                'teaching_specializations' => $data['teaching_specializations'] ?? [],
                'education_level'          => $data['education_level'],
                'years_of_experience'      => $data['years_of_experience'],
                'language_preference'      => $data['language_preference'] ?? 'en',
            ]
        );

        $profile->institutions()->sync($data['institution_ids'] ?? []);
        $profile->subjectRecords()->sync($data['subject_ids'] ?? []);

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

        // Use forceFill + save so no mass-assignment guard can interfere,
        // then refresh the in-memory instance so the edit() re-read is clean.
        $user->forceFill(['profile_photo_path' => $path])->save();
        $user->refresh();

        return redirect()->route('tutor.profile.edit')->with('success', 'Profile photo updated.');
    }
}