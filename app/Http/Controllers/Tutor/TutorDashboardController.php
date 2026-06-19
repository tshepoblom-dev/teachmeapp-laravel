<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class TutorDashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $tutor   = $request->user()->load(['profile.tutorTier', 'wallet']);
        $profile = $tutor->profile;
        $wallet  = $tutor->wallet;

        // Upcoming confirmed bookings
        $upcoming = Booking::with('student:id,name,email')
            ->where('tutor_id', $tutor->id)
            ->whereIn('status', ['accepted', 'in_progress'])
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get()
            ->map(fn ($b) => [
                'id'           => $b->id,
                'student_name' => $b->student->name,
                'subject'      => $b->subject,
                'scheduled_at' => $b->scheduled_at->toIso8601String(),
                'duration'     => $b->duration_minutes,
                'total'        => (float) $b->total_amount,
                'status'       => $b->status->value,
            ]);

        // Earnings last 30 days
        $earningsThisMonth = WalletTransaction::where('wallet_id', $wallet?->id)
            ->where('type', 'escrow_release')
            ->where('direction', 'credit')
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('amount');

        // Earnings last 7 days (chart)
        $earningsChart = WalletTransaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->where('wallet_id', $wallet?->id)
            ->where('type', 'escrow_release')
            ->where('direction', 'credit')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Fill missing days
        $chart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date    = now()->subDays($i)->toDateString();
            $chart[] = [
                'date'  => $date,
                'label' => now()->subDays($i)->format('D'),
                'total' => (float) ($earningsChart[$date]->total ?? 0),
            ];
        }

        // Tier progress
        $currentSessions = (int) ($profile?->total_sessions_hosted ?? 0);
        $tier            = $profile?->tutorTier;
        $nextTier        = $tier
            ? \App\Models\TutorTier::where('sessions_threshold', '>', $tier->sessions_threshold)
                ->where('is_active', true)
                ->orderBy('sessions_threshold')
                ->first()
            : \App\Models\TutorTier::where('is_active', true)->orderBy('sessions_threshold')->first();

        // Recent reviews
        $reviews = \App\Models\Review::with('reviewer:id,name')
            ->where('reviewee_id', $tutor->id)
            ->where('is_visible', true)
            ->latest('reviewed_at')
            ->limit(3)
            ->get()
            ->map(fn ($r) => [
                'reviewer'  => $r->reviewer->name,
                'rating'    => $r->rating,
                'comment'   => $r->comment,
                'date'      => $r->reviewed_at->diffForHumans(),
            ]);

        return Inertia::render('Tutor/Dashboard', [
            'stats' => [
                'balance'             => (float) ($wallet?->balance ?? 0),
                'escrow_balance'      => (float) ($wallet?->escrow_balance ?? 0),
                'earnings_this_month' => (float) $earningsThisMonth,
                'total_sessions'      => $currentSessions,
                'average_rating'      => (float) ($profile?->average_rating ?? 0),
                'total_reviews'       => (int) ($profile?->total_reviews ?? 0),
                'pending_requests'    => Booking::where('tutor_id', $tutor->id)
                                            ->where('status', 'pending')->count(),
            ],
            'tier' => $tier ? [
                'name'   => $tier->name,
                'colour' => $tier->theme_colour_primary,
                'commission_rate' => $tier->commission_rate,
            ] : null,
            'next_tier' => $nextTier ? [
                'name'      => $nextTier->name,
                'threshold' => $nextTier->sessions_threshold,
                'progress'  => $nextTier->sessions_threshold > 0
                    ? min(100, round(($currentSessions / $nextTier->sessions_threshold) * 100))
                    : 100,
                'remaining' => max(0, $nextTier->sessions_threshold - $currentSessions),
            ] : null,
            'upcoming'       => $upcoming,
            'earnings_chart' => $chart,
            'reviews'        => $reviews,
            'kyc_status'     => $profile?->kyc_status ?? 'not_submitted',
            'is_available'   => (bool) ($profile?->is_available ?? false),
        ]);
    }
}