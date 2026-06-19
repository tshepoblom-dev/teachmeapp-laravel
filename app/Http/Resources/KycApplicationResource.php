<?php

namespace App\Http\Resources;

use App\Services\KycService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KycApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user    = $request->user();
        $isAdmin = $user?->role->value === 'admin';

        return [
            'id'               => $this->id,
            'application_type' => $this->application_type,
            'status'           => $this->status,
            'submitted_at'     => $this->submitted_at?->toIso8601String(),
            'reviewed_at'      => $this->reviewed_at?->toIso8601String(),

            // Rejection reason is always shown to the applicant
            'rejection_reason' => $this->rejection_reason,

            // Admin notes are only shown to admins
            'admin_notes' => $this->when(
                $isAdmin,
                $this->admin_notes
            ),

            'resubmission_count' => $this->resubmission_count,

            // Reviewer info — admin only
            'reviewed_by' => $this->when(
                $isAdmin,
                fn () => $this->whenLoaded('reviewedBy', fn () => [
                    'id'   => $this->reviewedBy->id,
                    'name' => $this->reviewedBy->name,
                ])
            ),

            // Applicant info — admin only
            'applicant' => $this->when(
                $isAdmin,
                fn () => $this->whenLoaded('user', fn () => [
                    'id'    => $this->user->id,
                    'name'  => $this->user->name,
                    'email' => $this->user->email,
                    'role'  => $this->user->role->value,
                ])
            ),

            // Documents — shown to both applicant and admin
            'documents' => $this->whenLoaded(
                'documents',
                fn () => KycDocumentResource::collection($this->documents)
            ),

            // Helper fields for the applicant's UI
            'required_documents' => $this->when(
                ! $isAdmin,
                fn () => app(KycService::class)->requiredDocumentTypes()
            ),

            'missing_documents' => $this->when(
                ! $isAdmin,
                fn () => app(KycService::class)->missingDocuments($this->resource)
            ),

            'can_submit' => $this->when(
                ! $isAdmin,
                fn () => count(app(KycService::class)->missingDocuments($this->resource)) === 0
                    && in_array($this->status, ['pending', 'resubmitted'], true)
            ),

            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}