<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminKycApproveRequest;
use App\Http\Requests\AdminKycFlagRequest;
use App\Http\Requests\AdminKycRejectRequest;
use App\Http\Resources\KycApplicationResource;
use App\Models\KycApplication;
use App\Models\KycDocument;
use App\Services\KycService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class AdminKycController extends Controller
{
    public function __construct(
        private readonly KycService $kycService,
    ) {}

    // =========================================================================
    // GET /api/admin/kyc/applications
    // List all KYC applications with filters.
    // =========================================================================

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = KycApplication::with(['user', 'documents', 'reviewedBy'])
            ->latest('submitted_at');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        if ($request->filled('application_type')) {
            $query->where('application_type', $request->string('application_type'));
        }

        if ($request->filled('reviewed_by')) {
            $query->where('reviewed_by', $request->integer('reviewed_by'));
        }

        $applications = $query->paginate($request->integer('per_page', 20));

        return KycApplicationResource::collection($applications);
    }

    // =========================================================================
    // GET /api/admin/kyc/applications/{application}
    // View a single application with all documents and signed URLs.
    // =========================================================================

    public function show(Request $request, KycApplication $application): JsonResponse
    {
        $application->load(['user', 'documents', 'reviewedBy']);

        return $this->success(new KycApplicationResource($application));
    }

    // =========================================================================
    // POST /api/admin/kyc/{application}/flag
    // Move application to under_review status.
    // =========================================================================

    public function flag(AdminKycFlagRequest $request, KycApplication $application): JsonResponse
    {
        try {
            $application = $this->kycService->flagUnderReview(
                application: $application,
                admin: $request->user(),
            );

            return $this->success(
                data: new KycApplicationResource($application->load(['user', 'documents'])),
                message: 'Application flagged as under review.',
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/admin/kyc/{application}/approve
    // Approve the application — syncs profile + lifts pending_kyc account status.
    // =========================================================================

    public function approve(AdminKycApproveRequest $request, KycApplication $application): JsonResponse
    {
        try {
            $application = $this->kycService->approve(
                application: $application,
                admin: $request->user(),
                notes: $request->validated('notes'),
            );

            return $this->success(
                data: new KycApplicationResource($application->load(['user', 'documents', 'reviewedBy'])),
                message: 'KYC application approved. The user has been notified.',
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/admin/kyc/{application}/reject
    // Reject the application with a reason shown to the applicant.
    // =========================================================================

    public function reject(AdminKycRejectRequest $request, KycApplication $application): JsonResponse
    {
        try {
            $application = $this->kycService->reject(
                application: $application,
                admin: $request->user(),
                reason: $request->validated('reason'),
                notes: $request->validated('notes'),
            );

            return $this->success(
                data: new KycApplicationResource($application->load(['user', 'documents', 'reviewedBy'])),
                message: 'KYC application rejected. The applicant has been notified.',
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // GET /api/admin/kyc/documents/{document}/url
    // Generate a fresh signed URL for a specific document.
    // Called when the admin viewer needs to reload an expired URL.
    // =========================================================================

    public function documentUrl(Request $request, KycDocument $document): JsonResponse
    {
        try {
            $url = $this->kycService->signedUrl($document, expiryMinutes: 15);

            return $this->success([
                'url'        => $url,
                'expires_in' => '15 minutes',
                'document_id'=> $document->id,
            ]);
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    // =========================================================================
    // GET /api/admin/kyc/stats
    // Summary counts for admin dashboard KYC widget.
    // =========================================================================

    public function stats(): JsonResponse
    {
        $stats = [
            'pending'      => KycApplication::where('status', 'pending')->count(),
            'under_review' => KycApplication::where('status', 'under_review')->count(),
            'approved'     => KycApplication::where('status', 'approved')->count(),
            'rejected'     => KycApplication::where('status', 'rejected')->count(),
            'resubmitted'  => KycApplication::where('status', 'resubmitted')->count(),
            'total'        => KycApplication::count(),
        ];

        return $this->success($stats);
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function success(mixed $data, string $message = 'OK', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    private function error(string $message, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => null,
        ], $status);
    }
}