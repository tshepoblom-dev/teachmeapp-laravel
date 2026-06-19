<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StudentDashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $student = $request->user()->load('wallet');

        $upcoming = Booking::with('tutor:id,name', 'session:id,booking_id,status')
            ->where('student_id', $student->id)
            ->whereIn('status', ['accepted', 'in_progress'])
            // Include sessions scheduled for today onwards OR already running
            // (started within the last 4 hours in case they're still active).
            ->where(function ($q) {
                $q->where('scheduled_at', '>=', now())
                  ->orWhere('scheduled_at', '>=', now()->subHours(4));
            })
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get()
            ->map(fn ($b) => [
                'id'          => $b->id,
                'tutor_name'  => $b->tutor->name,
                'subject'     => $b->subject,
                'scheduled_at'=> $b->scheduled_at->toIso8601String(),
                'duration'    => $b->duration_minutes,
                'total'       => (float) $b->total_amount,
                'status'      => $b->status->value,
                'session_id'  => $b->session?->id,
            ]);

        $recentCompleted = Booking::with('tutor:id,name', 'review')
            ->where('student_id', $student->id)
            ->where('status', 'completed')
            ->latest('scheduled_at')
            ->limit(3)
            ->get()
            ->map(fn ($b) => [
                'id'          => $b->id,
                'tutor_name'  => $b->tutor->name,
                'subject'     => $b->subject,
                'scheduled_at'=> $b->scheduled_at->toIso8601String(),
                'has_review'  => (bool) $b->review,
            ]);

        // Recommended tutors (top-rated, available)
        $recommended = User::with('profile.tutorTier')
            ->tutors()
            ->active()
            ->whereHas('profile', fn ($q) => $q->where('is_available', true)->whereNotNull('hourly_rate'))
            ->orderByDesc(function ($q) {
                $q->select('average_rating')
                  ->from('profiles')
                  ->whereColumn('user_id', 'users.id')
                  ->limit(1);
            })
            ->limit(4)
            ->get()
            ->map(fn ($u) => [
                'id'             => $u->id,
                'name'           => $u->name,
                'subjects'       => $u->profile?->subjects ?? [],
                'hourly_rate'    => (float) ($u->profile?->hourly_rate ?? 0),
                'average_rating' => (float) ($u->profile?->average_rating ?? 0),
                'total_reviews'  => (int) ($u->profile?->total_reviews ?? 0),
                'tier'           => $u->profile?->tutorTier?->name,
                'tier_colour'    => $u->profile?->tutorTier?->theme_colour_primary,
            ]);

        return Inertia::render('Student/Dashboard', [
            'stats' => [
                'balance'         => (float) ($student->wallet?->balance ?? 0),
                'total_sessions'  => Booking::where('student_id', $student->id)->where('status', 'completed')->count(),
                'pending_bookings'=> Booking::where('student_id', $student->id)->where('status', 'pending')->count(),
            ],
            'upcoming'         => $upcoming,
            'recent_completed' => $recentCompleted,
            'recommended'      => $recommended,
        ]);
    }
}