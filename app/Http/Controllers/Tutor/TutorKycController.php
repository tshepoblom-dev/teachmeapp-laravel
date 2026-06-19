<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Services\KycService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TutorKycController extends Controller
{
    public function __construct(private readonly KycService $kycService) {}

    public function index(Request $request): Response
    {
        $user        = $request->user()->load('profile');
        $application = $user->kycApplications()
            ->with('kycDocuments')
            ->latest()
            ->first();

        return Inertia::render('Tutor/Kyc/Index', [
            'kyc_status'  => $user->profile?->kyc_status ?? 'not_submitted',
            'application' => $application ? [
                'id'                => $application->id,
                'status'            => $application->status,
                'submitted_at'      => $application->submitted_at?->toIso8601String(),
                'rejection_reason'  => $application->rejection_reason,
                'resubmission_count'=> $application->resubmission_count,
                'documents'         => $application->kycDocuments->map(fn ($d) => [
                    'id'            => $d->id,
                    'document_type' => $d->document_type,
                    'status'        => $d->status,
                    'mime_type'     => $d->mime_type,
                ]),
            ] : null,
            'document_types' => ['national_id','passport','drivers_licence','selfie','proof_of_qualification','proof_of_address'],
        ]);
    }

    public function apply(Request $request): RedirectResponse
    {
        try {
            $this->kycService->startApplication($request->user(), 'new_tutor');
            return back()->with('success', 'KYC application started. Please upload your documents.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function upload(Request $request): RedirectResponse
    {
        $request->validate([
            'document_type' => ['required', 'string'],
            'file'          => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,pdf'],
        ]);

        try {
            $application = $request->user()->kycApplications()
                ->whereIn('status', ['pending', 'resubmitted'])
                ->latest()
                ->firstOrFail();

            $this->kycService->uploadDocument($application, $request->file('file'), $request->document_type);
            return back()->with('success', 'Document uploaded.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteDocument(Request $request, \App\Models\KycDocument $document): RedirectResponse
    {
        abort_unless($document->user_id === $request->user()->id, 403);
        try {
            $this->kycService->deleteDocument($document);
            return back()->with('success', 'Document removed.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}