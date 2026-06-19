<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\Review;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;

class StudentDiscoverController extends Controller
{
    public function index(Request $request): Response
    {
        $query = User::with('profile.tutorTier')
            ->tutors()
            ->active()
            ->whereHas('profile', fn ($q) => $q->where('is_available', true));

        if ($search = $request->query('search')) {
            $query->where(fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhereHas('profile', fn ($q2) => $q2->where('bio', 'like', "%{$search}%"))
            );
        }

        if ($institutionId = $request->query('institution_id')) {
            $query->whereHas('profile.institutions', fn ($q) =>
                $q->where('institutions.id', $institutionId)
            );
        }

        if ($subjectId = $request->query('subject_id')) {
            $query->whereHas('profile.subjectRecords', fn ($q) =>
                $q->where('subjects.id', $subjectId)
            );
        }

        if ($maxRate = $request->query('max_rate')) {
            $query->whereHas('profile', fn ($q) => $q->where('hourly_rate', '<=', $maxRate));
        }

        if ($minRating = $request->query('min_rating')) {
            $query->whereHas('profile', fn ($q) => $q->where('average_rating', '>=', $minRating));
        }

        $sort = $request->query('sort', 'rating');
        match ($sort) {
            'rate_asc'  => $query->orderByRaw('(SELECT hourly_rate FROM profiles WHERE user_id = users.id) ASC'),
            'rate_desc' => $query->orderByRaw('(SELECT hourly_rate FROM profiles WHERE user_id = users.id) DESC'),
            default     => $query->orderByRaw('(SELECT average_rating FROM profiles WHERE user_id = users.id) DESC'),
        };

        $tutors = $query->paginate(12)->through(function ($u) {
            $profile = $u->profile;
            return [
                'id'             => $u->id,
                'name'           => $u->name,
                'bio'            => $profile?->bio,
                'subjects'       => $profile?->subjectRecords->map(fn ($s) => [
                    'id'   => $s->id,
                    'name' => $s->name,
                    'code' => $s->code,
                ]) ?? [],
                'institutions'   => $profile?->institutions->map(fn ($i) => [
                    'id'           => $i->id,
                    'name'         => $i->name,
                    'abbreviation' => $i->abbreviation,
                ]) ?? [],
                'hourly_rate'    => (float) ($profile?->hourly_rate ?? 0),
                'average_rating' => (float) ($profile?->average_rating ?? 0),
                'total_reviews'  => (int) ($profile?->total_reviews ?? 0),
                'tier'           => $profile?->tutorTier?->name,
                'tier_colour'    => $profile?->tutorTier?->theme_colour_primary,
                'avatar_url' => $u->profile_photo_path
                                ? Storage::url($u->profile_photo_path)
                                : null,
            ];
        });

        // Filter-dropdown data — only active, ordered
        $institutions = Institution::active()
            ->orderBy('sort_order')->orderBy('name')
            ->get(['id', 'name', 'abbreviation', 'type']);

        // If an institution is selected, show its subjects + universal ones
        $subjectsQuery = Subject::where('is_active', true)
            ->orderBy('sort_order')->orderBy('name');

        if ($institutionId) {
            $subjectsQuery->where(fn ($q) =>
                $q->where('institution_id', $institutionId)->orWhereNull('institution_id')
            );
        }

        $subjects = $subjectsQuery->get(['id', 'name', 'code', 'faculty', 'institution_id']);

        return Inertia::render('Student/Discover/Index', [
            'tutors'       => $tutors,
            'filters'      => $request->only('search', 'institution_id', 'subject_id', 'max_rate', 'min_rating', 'sort'),
            'institutions' => $institutions,
            'subjects'     => $subjects,
        ]);
    }

    public function profile(Request $request, User $user): Response
    {
        abort_unless($user->role->value === 'tutor', 404);
        $user->load('profile.tutorTier', 'profile.institutions', 'profile.subjectRecords', 'availabilitySlots');

        $reviews = Review::with('reviewer:id,name')
            ->where('reviewee_id', $user->id)
            ->where('is_visible', true)
            ->latest('reviewed_at')
            ->limit(10)
            ->get()
            ->map(fn ($r) => [
                'reviewer' => $r->reviewer->name,
                'rating'   => $r->rating,
                'comment'  => $r->comment,
                'tags'     => $r->tags ?? [],
                'date'     => $r->reviewed_at->diffForHumans(),
            ]);

        $slots = $user->availabilitySlots
            ->where('is_active', true)
            ->map(fn ($s) => [
                'day_of_week' => $s->day_of_week,
                'start_time'  => substr($s->start_time, 0, 5),
                'end_time'    => substr($s->end_time, 0, 5),
            ]);

        return Inertia::render('Student/Discover/Profile', [
            'tutor' => [
                'id'                       => $user->id,
                'name'                     => $user->name,
                'bio'                      => $user->profile?->bio,
                'subjects'                 => $user->profile?->subjectRecords->map(fn ($s) => [
                    'id' => $s->id, 'name' => $s->name, 'code' => $s->code, 'faculty' => $s->faculty,
                ]) ?? [],
                'institutions'             => $user->profile?->institutions->map(fn ($i) => [
                    'id' => $i->id, 'name' => $i->name, 'abbreviation' => $i->abbreviation, 'type' => $i->type,
                ]) ?? [],
                'hourly_rate'              => (float) ($user->profile?->hourly_rate ?? 0),
                'average_rating'           => (float) ($user->profile?->average_rating ?? 0),
                'total_reviews'            => (int) ($user->profile?->total_reviews ?? 0),
                'total_sessions'           => (int) ($user->profile?->total_sessions_hosted ?? 0),
                'education_level'          => $user->profile?->education_level,
                'years_of_experience'      => $user->profile?->years_of_experience,
                'teaching_specializations' => $user->profile?->teaching_specializations ?? [],
                'tier'                     => $user->profile?->tutorTier?->name,
                'tier_colour'              => $user->profile?->tutorTier?->theme_colour_primary,
                'is_available'             => (bool) ($user->profile?->is_available ?? false),       
                'avatar_url' => $user->profile_photo_path ? Storage::url($user->profile_photo_path) : null,
            ],
            'availability' => $slots->values(),
            'reviews'      => $reviews,
        ]);
    }
}