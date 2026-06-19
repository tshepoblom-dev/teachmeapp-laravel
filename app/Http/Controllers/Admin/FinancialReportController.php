<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EscrowTransaction;
use App\Models\PaymentTransaction;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FinancialReportController extends Controller
{
    public function index(Request $request): Response
    {
        $from = $request->from
            ? \Carbon\Carbon::parse($request->from)->startOfDay()
            : now()->subDays(30)->startOfDay();

        $to = $request->to
            ? \Carbon\Carbon::parse($request->to)->endOfDay()
            : now()->endOfDay();

        // Total platform commission in range
        $commission = WalletTransaction::where('type', 'platform_fee')
            ->whereBetween('created_at', [$from, $to])
            ->sum('amount');

        // Total deposited via gateways
        $deposited = PaymentTransaction::where('status', 'completed')
            ->whereBetween('completed_at', [$from, $to])
            ->sum('amount');

        // Total paid out to tutors
        $paidToTutors = WalletTransaction::where('type', 'escrow_release')
            ->whereBetween('created_at', [$from, $to])
            ->sum('amount');

        // Total refunded to students
        $refunded = WalletTransaction::where('type', 'escrow_refund')
            ->whereBetween('created_at', [$from, $to])
            ->sum('amount');

        // Daily breakdown for chart
        $dailyRevenue = WalletTransaction::where('type', 'platform_fee')
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn ($r) => [
                'date'  => $r->date,
                'total' => (float) $r->total,
            ]);

        // Payment method breakdown
        $byMethod = PaymentTransaction::where('status', 'completed')
            ->whereBetween('completed_at', [$from, $to])
            ->with('paymentMethod:id,name,code')
            ->selectRaw('payment_method_id, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method_id')
            ->get()
            ->map(fn ($r) => [
                'method' => $r->paymentMethod?->name ?? 'Unknown',
                'code'   => $r->paymentMethod?->code,
                'count'  => (int) $r->count,
                'total'  => (float) $r->total,
            ]);

        // Recent escrow releases
        $recentReleases = EscrowTransaction::where('status', 'released')
            ->whereBetween('released_at', [$from, $to])
            ->with(['booking.tutor:id,name'])
            ->latest('released_at')
            ->take(15)
            ->get()
            ->map(fn ($e) => [
                'id'               => $e->id,
                'booking_id'       => $e->booking_id,
                'tutor'            => $e->booking?->tutor?->name,
                'gross'            => (float) $e->amount,
                'commission'       => (float) $e->commission_amount,
                'net_to_tutor'     => (float) $e->net_to_tutor,
                'commission_rate'  => (float) $e->commission_rate_snapshot,
                'released_at'      => $e->released_at?->toDateString(),
            ]);

        return Inertia::render('Admin/Financials/Index', [
            'summary' => [
                'commission'    => (float) $commission,
                'deposited'     => (float) $deposited,
                'paid_to_tutors'=> (float) $paidToTutors,
                'refunded'      => (float) $refunded,
            ],
            'dailyRevenue'   => $dailyRevenue,
            'byMethod'       => $byMethod,
            'recentReleases' => $recentReleases,
            'filters'        => [
                'from' => $from->toDateString(),
                'to'   => $to->toDateString(),
            ],
            'pendingKyc' => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }
}