<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycApplication;
use App\Models\Report;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class ReportWebController extends Controller
{
    public function __construct(private readonly ReportService $reportService) {}

    public function index(Request $request): Response
    {
        $reports = Report::with([
            'reporter:id,name,email',
            'reported:id,name,email',
            'resolvedBy:id,name',
            'booking:id,subject',
        ])
        ->when($request->status, fn ($q) => $q->where('status', $request->status))
        ->latest()
        ->paginate(20)
        ->withQueryString()
        ->through(fn ($r) => [
            'id'            => $r->id,
            'status'        => $r->status,
            'reason'        => $r->reason,
            'description'   => $r->description,
            'action_taken'  => $r->action_taken,
            'admin_notes'   => $r->admin_notes,
            'reporter'      => $r->reporter?->name,
            'reporter_email'=> $r->reporter?->email,
            'reported'      => $r->reported?->name,
            'reported_email'=> $r->reported?->email,
            'reported_id'   => $r->reported_id,
            'resolved_by'   => $r->resolvedBy?->name,
            'resolved_at'   => $r->resolved_at?->toDateString(),
            'booking_id'    => $r->booking_id,
            'session_id'    => $r->session_id,
            'subject'       => $r->booking?->subject,
            'created_at'    => $r->created_at->toDateString(),
        ]);

        $stats = [
            'pending'      => Report::where('status', 'pending')->count(),
            'under_review' => Report::where('status', 'under_review')->count(),
            'resolved'     => Report::where('status', 'resolved')->count(),
            'dismissed'    => Report::where('status', 'dismissed')->count(),
        ];

        return Inertia::render('Admin/Reports/Index', [
            'reports'    => $reports,
            'stats'      => $stats,
            'filters'    => $request->only(['status']),
            'pendingKyc' => KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function markUnderReview(Request $request, Report $report): RedirectResponse
    {
        try {
            $this->reportService->markUnderReview($report, $request->user());
            return back()->with('success', "Report #{$report->id} marked as under review.");
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function warn(Request $request, Report $report): RedirectResponse
    {
        $request->validate([
            'admin_notes' => ['required', 'string', 'max:1000'],
            'flag_escrow' => ['boolean'],
        ]);

        try {
            $this->reportService->warn(
                $report,
                $request->user(),
                $request->admin_notes,
                (bool) $request->flag_escrow,
            );
            return back()->with('success', "Warning issued to {$report->reported?->name}. Report resolved.");
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function suspend(Request $request, Report $report): RedirectResponse
    {
        $request->validate([
            'admin_notes'    => ['required', 'string', 'max:1000'],
            'suspended_until'=> ['nullable', 'date', 'after:now'],
            'flag_escrow'    => ['boolean'],
        ]);

        try {
            $until = $request->suspended_until ? Carbon::parse($request->suspended_until) : null;
            $this->reportService->suspend(
                $report,
                $request->user(),
                $request->admin_notes,
                $until,
                (bool) $request->flag_escrow,
            );
            return back()->with('success', "User suspended. Report resolved.");
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function dismiss(Request $request, Report $report): RedirectResponse
    {
        $request->validate([
            'admin_notes' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $this->reportService->dismiss($report, $request->user(), $request->admin_notes);
            return back()->with('success', "Report #{$report->id} dismissed.");
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}