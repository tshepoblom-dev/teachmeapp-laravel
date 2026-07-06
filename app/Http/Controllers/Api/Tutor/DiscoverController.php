<?php

namespace App\Http\Controllers\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tutor\DiscoverTutorsRequest;
use App\Http\Resources\TutorProfileResource;
use App\Http\Resources\TutorSummaryResource;
use App\Models\Review;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    use ApiResponse;

    // ── GET /api/tutors ───────────────────────────────────────────────────────

    public function index(DiscoverTutorsRequest $request): JsonResponse
    {
        $query = User::with('profile.tutorTier', 'profile.subjectRecords', 'profile.institutions')
            ->tutors()
            ->active()
            ->whereHas('profile', fn ($q) => $q->where('is_available', true));

        if ($search = $request->validated('search')) {
            $query->where(fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhereHas('profile', fn ($q2) => $q2->where('bio', 'like', "%{$search}%"))
            );
        }

        if ($institutionId = $request->validated('institution_id')) {
            $query->whereHas('profile.institutions', fn ($q) => $q->where('institutions.id', $institutionId));
        }

        if ($subjectId = $request->validated('subject_id')) {
            $query->whereHas('profile.subjectRecords', fn ($q) => $q->where('subjects.id', $subjectId));
        }

        if ($maxRate = $request->validated('max_rate')) {
            $query->whereHas('profile', fn ($q) => $q->where('hourly_rate', '<=', $maxRate));
        }

        if ($minRating = $request->validated('min_rating')) {
            $query->whereHas('profile', fn ($q) => $q->where('average_rating', '>=', $minRating));
        }

        $sort = $request->validated('sort', 'rating');
        match ($sort) {
            'rate_asc'  => $query->orderByRaw('(SELECT hourly_rate FROM profiles WHERE user_id = users.id) ASC'),
            'rate_desc' => $query->orderByRaw('(SELECT hourly_rate FROM profiles WHERE user_id = users.id) DESC'),
            default     => $query->orderByRaw('(SELECT average_rating FROM profiles WHERE user_id = users.id) DESC'),
        };

        $tutors = $query->paginate(12);

        return $this->success(TutorSummaryResource::collection($tutors)->response()->getData(true));
    }

    // ── GET /api/tutors/{user} ────────────────────────────────────────────────

    public function show(Request $request, User $user): JsonResponse
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
            ])
            ->values();

        return $this->success([
            'tutor'        => new TutorProfileResource($user),
            'availability' => $slots,
            'reviews'      => $reviews,
        ]);
    }
}
