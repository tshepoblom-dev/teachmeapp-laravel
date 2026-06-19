<?php

namespace App\Services;

use App\Enums\KycStatus;
use App\Models\KycApplication;
use App\Models\KycDocument;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use App\Events\KycApproved;
use App\Events\KycRejected;

class KycService
{
    // Private disk name — never public
    private const DISK = 'private';

    // Maximum resubmissions allowed before locking the applicant out
    private const MAX_RESUBMISSIONS = 3;

    // =========================================================================
    // APPLY
    // Creates a new KYC application for a user.
    // Only one active application allowed at a time.
    // =========================================================================

    public function apply(User $user, string $applicationType): KycApplication
    {
        return DB::transaction(function () use ($user, $applicationType) {

            // Guard: block if already approved
            if ($user->profile?->kyc_status === KycStatus::Approved) {
                throw new RuntimeException('Your identity has already been verified.');
            }

            // Guard: block if pending or under review
            $existing = KycApplication::where('user_id', $user->id)
                ->whereIn('status', [KycStatus::Pending, KycStatus::UnderReview])
                ->first();

            if ($existing) {
                throw new RuntimeException(
                    'You already have a KYC application in progress. ' .
                    "Current status: {$existing->status}"
                );
            }

            // Check resubmission count on most recent rejected application
            $lastRejected = KycApplication::where('user_id', $user->id)
                ->where('status', 'rejected')
                ->latest()
                ->first();

            if ($lastRejected && $lastRejected->resubmission_count >= self::MAX_RESUBMISSIONS) {
                throw new RuntimeException(
                    'You have exceeded the maximum number of KYC resubmissions. ' .
                    'Please contact support.'
                );
            }

            $application = KycApplication::create([
                'user_id'            => $user->id,
                'application_type'   => $applicationType,
                'status'             => 'pending',
                'submitted_at'       => now(),
                'resubmission_count' => $lastRejected
                    ? $lastRejected->resubmission_count + 1
                    : 0,
            ]);

            // Sync profile KYC status
            Profile::where('user_id', $user->id)->update([
                'kyc_status'           => 'pending',
                'kyc_application_id'   => $application->id,
            ]);

            Log::info('KYC application created', [
                'application_id' => $application->id,
                'user_id'        => $user->id,
                'type'           => $applicationType,
            ]);

            return $application;
        });
    }

    // =========================================================================
    // UPLOAD DOCUMENT
    // Stores a document to the private disk and creates a KycDocument record.
    // File hash stored for integrity verification.
    // =========================================================================

    public function uploadDocument(
        KycApplication $application,
        UploadedFile   $file,
        string         $documentType,
    ): KycDocument {

        // Guard: application must be pending (not under_review or decided)
        if (! in_array($application->status, ['pending', 'resubmitted'], true)) {
            throw new RuntimeException(
                'Documents can only be uploaded to a pending application.'
            );
        }

        // Guard: no duplicate document types on same application
        $existing = KycDocument::where('kyc_application_id', $application->id)
            ->where('document_type', $documentType)
            ->where('status', '!=', 'rejected')
            ->first();

        if ($existing) {
            throw new RuntimeException(
                "A {$documentType} document has already been uploaded for this application. " .
                'Delete it first before uploading a new one.'
            );
        }

        return DB::transaction(function () use ($application, $file, $documentType) {

            // Build a private, non-guessable path
            $extension = $file->getClientOriginalExtension();
            $filename  = Str::uuid() . '.' . $extension;
            $path      = "kyc/{$application->user_id}/{$application->id}/{$filename}";

            // Store to private disk
            $file->storeAs(
                path: "kyc/{$application->user_id}/{$application->id}",
                name: $filename,
                options: ['disk' => self::DISK],
            );

            // Compute SHA-256 hash for integrity verification
            $hash = hash('sha256', file_get_contents($file->getRealPath()));

            $document = KycDocument::create([
                'kyc_application_id' => $application->id,
                'user_id'            => $application->user_id,
                'document_type'      => $documentType,
                'file_path'          => $path,
                'file_hash'          => $hash,
                'mime_type'          => $file->getMimeType(),
                'file_size_kb'       => (int) round($file->getSize() / 1024),
                'status'             => 'uploaded',
            ]);

            Log::info('KYC document uploaded', [
                'document_id'    => $document->id,
                'application_id' => $application->id,
                'type'           => $documentType,
                'size_kb'        => $document->file_size_kb,
            ]);

            return $document;
        });
    }

    // =========================================================================
    // DELETE DOCUMENT
    // Removes a document before submission (pending state only).
    // Deletes from disk and removes the DB record.
    // =========================================================================

    public function deleteDocument(KycDocument $document, User $user): void
    {
        // Guard: only the document owner can delete
        if ($document->user_id !== $user->id) {
            throw new RuntimeException('You do not have permission to delete this document.');
        }

        // Guard: only deletable if application is still pending
        $application = $document->kycApplication;
        if (! in_array($application->status, ['pending', 'resubmitted'], true)) {
            throw new RuntimeException(
                'Documents cannot be deleted once the application is under review.'
            );
        }

        DB::transaction(function () use ($document) {
            // Remove from private disk
            Storage::disk(self::DISK)->delete($document->file_path);

            $document->delete();
        });

        Log::info('KYC document deleted', [
            'document_id'    => $document->id,
            'application_id' => $document->kyc_application_id,
            'user_id'        => $user->id,
        ]);
    }

    // =========================================================================
    // GENERATE SIGNED URL
    // Returns a time-limited signed URL for a private document.
    // Used by admin review UI. Never returns the raw file path.
    // =========================================================================

    public function signedUrl(KycDocument $document, int $expiryMinutes = 15): string
    {
        if (! Storage::disk(self::DISK)->exists($document->file_path)) {
            throw new RuntimeException('Document file not found on storage.');
        }

        // Laravel's private disk temporary URL (works with S3, local with tweaks)
        return Storage::disk(self::DISK)->temporaryUrl(
            path: $document->file_path,
            expiration: now()->addMinutes($expiryMinutes),
        );
    }

    // =========================================================================
    // ADMIN — APPROVE
    // Marks application approved, syncs profile KYC status.
    // =========================================================================

    public function approve(
        KycApplication $application,
        User           $admin,
        ?string        $notes = null,
    ): KycApplication {
        return DB::transaction(function () use ($application, $admin, $notes) {

            $this->assertReviewable($application);

            $application->update([
                'status'      => 'approved',
                'reviewed_at' => now(),
                'reviewed_by' => $admin->id,
                'admin_notes' => $notes,
            ]);

            // Mark all documents as verified
            KycDocument::where('kyc_application_id', $application->id)
                ->where('status', 'uploaded')
                ->update([
                    'status'      => 'verified',
                    'verified_at' => now(),
                ]);

            // Sync profile
            Profile::where('user_id', $application->user_id)->update([
                'kyc_status'  => 'approved',
                'id_verified' => true,
            ]);

            // Sync user account status if it was pending_kyc
            $user = $application->user;
            if ($user->account_status->value === 'pending_kyc') {
                $user->update(['account_status' => 'active']);
            }

            Log::info('KYC application approved', [
                'application_id' => $application->id,
                'user_id'        => $application->user_id,
                'admin_id'       => $admin->id,
            ]);

            $fresh = $application->fresh();
            KycApproved::dispatch($fresh);
            return $fresh;
        });
    }

    // =========================================================================
    // ADMIN — REJECT
    // Marks application rejected with reason shown to applicant.
    // =========================================================================

    public function reject(
        KycApplication $application,
        User           $admin,
        string         $reason,
        ?string        $notes = null,
    ): KycApplication {
        return DB::transaction(function () use ($application, $admin, $reason, $notes) {

            $this->assertReviewable($application);

            $application->update([
                'status'           => 'rejected',
                'reviewed_at'      => now(),
                'reviewed_by'      => $admin->id,
                'rejection_reason' => $reason,
                'admin_notes'      => $notes,
            ]);

            // Sync profile
            Profile::where('user_id', $application->user_id)->update([
                'kyc_status' => 'rejected',
            ]);

            Log::info('KYC application rejected', [
                'application_id' => $application->id,
                'user_id'        => $application->user_id,
                'admin_id'       => $admin->id,
                'reason'         => $reason,
            ]);
            $fresh = $application->fresh();
            KycRejected::dispatch($fresh);
            return $fresh;
        });
    }

    // =========================================================================
    // ADMIN — FLAG UNDER REVIEW
    // Moves application from pending → under_review so admin can study docs.
    // =========================================================================

    public function flagUnderReview(KycApplication $application, User $admin): KycApplication
    {
        if ($application->status !== 'pending' && $application->status !== 'resubmitted') {
            throw new RuntimeException(
                "Only pending or resubmitted applications can be flagged for review."
            );
        }

        $application->update([
            'status'      => 'under_review',
            'reviewed_by' => $admin->id,
        ]);

        Profile::where('user_id', $application->user_id)
            ->update(['kyc_status' => 'pending']);

        Log::info('KYC application flagged under review', [
            'application_id' => $application->id,
            'user_id'        => $application->user_id,
            'admin_id'       => $admin->id,
        ]);

        return $application->fresh();
    }

    // =========================================================================
    // GET STATUS
    // Returns the current application and document list for a user.
    // =========================================================================

    public function getStatusForUser(User $user): array
    {
        $application = KycApplication::where('user_id', $user->id)
            ->with(['documents', 'reviewedBy:id,name'])
            ->latest()
            ->first();

        return [
            'kyc_status'     => $user->profile?->kyc_status ?? 'not_submitted',
            'application'    => $application,
            'required_docs'  => $this->requiredDocumentTypes(),
            'missing_docs'   => $application
                ? $this->missingDocuments($application)
                : $this->requiredDocumentTypes(),
        ];
    }

    // =========================================================================
    // HELPERS
    // =========================================================================

    public function requiredDocumentTypes(): array
    {
        return ['national_id', 'selfie'];
    }

    public function missingDocuments(KycApplication $application): array
    {
        $uploaded = KycDocument::where('kyc_application_id', $application->id)
            ->where('status', '!=', 'rejected')
            ->pluck('document_type')
            ->toArray();

        return array_values(
            array_diff($this->requiredDocumentTypes(), $uploaded)
        );
    }

    private function assertReviewable(KycApplication $application): void
    {
        $reviewable = ['pending', 'under_review', 'resubmitted'];

        if (! in_array($application->status, $reviewable, true)) {
            throw new RuntimeException(
                "This application cannot be reviewed. Current status: {$application->status}"
            );
        }
    }
}