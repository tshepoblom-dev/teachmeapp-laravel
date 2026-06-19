<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycApplication;
use App\Services\KycService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminKycWebController extends Controller
{
    public function __construct(
        private readonly KycService $kycService,
    ) {}

    public function index(Request $request): Response
    {
        $applications = KycApplication::with(['user:id,name,email', 'reviewedBy:id,name'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest('submitted_at')
            ->paginate(20)
            ->withQueryString()
            ->through(fn ($a) => [
                'id'               => $a->id,
                'status'           => $a->status,
                'application_type' => $a->application_type,
                'submitted_at'     => $a->submitted_at?->toDateString(),
                'reviewed_at'      => $a->reviewed_at?->toDateString(),
                'user'             => ['id' => $a->user?->id, 'name' => $a->user?->name, 'email' => $a->user?->email],
                'reviewed_by'      => $a->reviewedBy?->name,
                'resubmission_count' => $a->resubmission_count,
            ]);

        $stats = [
            'pending'      => KycApplication::where('status', 'pending')->count(),
            'under_review' => KycApplication::where('status', 'under_review')->count(),
            'approved'     => KycApplication::where('status', 'approved')->count(),
            'rejected'     => KycApplication::where('status', 'rejected')->count(),
        ];

        return Inertia::render('Admin/Kyc/Index', [
            'applications' => $applications,
            'stats'        => $stats,
            'filters'      => $request->only(['status']),
            'pendingKyc'   => $stats['pending'],
        ]);
    }

    public function show(KycApplication $application): Response
    {
        $application->load(['user', 'documents', 'reviewedBy']);

        // Generate signed URLs for each document
        $documents = $application->documents->map(function ($doc) {
            $url = null;
            try {
                $url = $this->kycService->signedUrl($doc, 30);
            } catch (\Throwable) {}

            return [
                'id'            => $doc->id,
                'document_type' => $doc->document_type,
                'status'        => $doc->status,
                'mime_type'     => $doc->mime_type,
                'file_size_kb'  => $doc->file_size_kb,
                'signed_url'    => $url,
                'uploaded_at'   => $doc->created_at?->toDateString(),
            ];
        });

        return Inertia::render('Admin/Kyc/Show', [
            'application' => array_merge($application->toArray(), [
                'documents' => $documents,
            ]),
            'pendingKyc' => KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function approve(Request $request, KycApplication $application): RedirectResponse
    {
        $request->validate(['notes' => ['nullable', 'string', 'max:1000']]);

        $this->kycService->approve($application, $request->user(), $request->notes);

        return redirect()->route('admin.kyc.index')
            ->with('success', 'KYC application approved.');
    }

    public function reject(Request $request, KycApplication $application): RedirectResponse
    {
        $request->validate([
            'reason' => ['required', 'string', 'min:10', 'max:1000'],
            'notes'  => ['nullable', 'string', 'max:1000'],
        ]);

        $this->kycService->reject($application, $request->user(), $request->reason, $request->notes);

        return redirect()->route('admin.kyc.index')
            ->with('success', 'KYC application rejected.');
    }
}