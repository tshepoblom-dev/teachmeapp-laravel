<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\KycApplication;
use App\Models\Session;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'total_users'       => User::count(),
            'total_tutors'      => User::where('role', 'tutor')->count(),
            'total_students'    => User::where('role', 'student')->count(),
            'active_sessions'   => Session::where('status', 'active')->count(),
            'pending_bookings'  => Booking::where('status', 'pending')->count(),
            'pending_kyc'       => KycApplication::where('status', 'pending')->count(),
            'completed_today'   => Booking::where('status', 'completed')
                ->whereDate('updated_at', today())
                ->count(),
        ];

        // Revenue — last 30 days commission collected
        $revenue = WalletTransaction::where('type', 'platform_fee')
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('amount');

        // Revenue by day — last 14 days for chart
        $revenueChart = WalletTransaction::where('type', 'platform_fee')
            ->where('created_at', '>=', now()->subDays(14))
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn ($r) => [
                'date'  => $r->date,
                'total' => (float) $r->total,
            ]);

        // Recent bookings
        $recentBookings = Booking::with(['student:id,name', 'tutor:id,name'])
            ->latest()
            ->take(8)
            ->get()
            ->map(fn ($b) => [
                'id'           => $b->id,
                'status'       => $b->status->value,
                'subject'      => $b->subject,
                'total_amount' => (float) $b->total_amount,
                'student'      => $b->student?->name,
                'tutor'        => $b->tutor?->name,
                'scheduled_at' => $b->scheduled_at?->copy()->setTimezone(config('app.local_timezone'))->toIso8601String(),
            ]);

        // New users — last 7 days
        $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();

        return Inertia::render('Admin/Dashboard', [
            'stats'         => $stats,
            'revenue'       => (float) $revenue,
            'revenueChart'  => $revenueChart,
            'recentBookings'=> $recentBookings,
            'newUsers'      => $newUsers,
            'pendingKyc'    => $stats['pending_kyc'],
        ]);
    }
}