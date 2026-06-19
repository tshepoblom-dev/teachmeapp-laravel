<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyKycRequest;
use App\Http\Requests\DeleteKycDocumentRequest;
use App\Http\Requests\UploadKycDocumentRequest;
use App\Http\Resources\KycApplicationResource;
use App\Models\KycDocument;
use App\Services\KycService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class KycController extends Controller
{
    public function __construct(
        private readonly KycService $kycService,
    ) {}

    // =========================================================================
    // GET /api/kyc/status
    // Returns current KYC status, latest application, and missing documents.
    // =========================================================================

    public function status(Request $request): JsonResponse
    {
        $status = $this->kycService->getStatusForUser($request->user());

        return $this->success([
            'kyc_status'      => $status['kyc_status'],
            'required_docs'   => $status['required_docs'],
            'missing_docs'    => $status['missing_docs'],
            'application'     => $status['application']
                ? new KycApplicationResource(
                    $status['application']->loadMissing(['documents', 'reviewedBy'])
                  )
                : null,
        ]);
    }

    // =========================================================================
    // POST /api/kyc/apply
    // Start a new KYC application.
    // =========================================================================

    public function apply(ApplyKycRequest $request): JsonResponse
    {
        try {
            $application = $this->kycService->apply(
                user: $request->user(),
                applicationType: $request->validated('application_type'),
            );

            return $this->success(
                data: new KycApplicationResource(
                    $application->loadMissing(['documents'])
                ),
                message: 'KYC application created. Please upload the required documents.',
                status: 201,
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/kyc/documents
    // Upload a document to the current pending application.
    // =========================================================================

    public function uploadDocument(UploadKycDocumentRequest $request): JsonResponse
    {
        $user = $request->user();

        // Resolve the current active application
        $application = \App\Models\KycApplication::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'resubmitted'])
            ->latest()
            ->first();

        if (! $application) {
            return $this->error(
                'No active KYC application found. Please start an application first.',
                422
            );
        }

        try {
            $document = $this->kycService->uploadDocument(
                application: $application,
                file: $request->file('file'),
                documentType: $request->validated('document_type'),
            );

            return $this->success(
                data: [
                    'document_id'   => $document->id,
                    'document_type' => $document->document_type,
                    'status'        => $document->status,
                    'file_size_kb'  => $document->file_size_kb,
                    'mime_type'     => $document->mime_type,
                    'uploaded_at'   => $document->created_at?->toIso8601String(),
                ],
                message: ucfirst(str_replace('_', ' ', $document->document_type)) . ' uploaded successfully.',
                status: 201,
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // DELETE /api/kyc/documents/{document}
    // Remove a document from a pending application.
    // =========================================================================

    public function deleteDocument(DeleteKycDocumentRequest $request, KycDocument $document): JsonResponse
    {
        try {
            $this->kycService->deleteDocument(
                document: $document,
                user: $request->user(),
            );

            return $this->success(
                data: null,
                message: 'Document removed successfully.',
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
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