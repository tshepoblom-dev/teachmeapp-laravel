<?php

namespace App\Http\Resources;

use App\Services\KycService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KycDocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user    = $request->user();
        $isAdmin = $user?->role->value === 'admin';

        return [
            'id'             => $this->id,
            'document_type'  => $this->document_type,
            'status'         => $this->status,
            'mime_type'      => $this->mime_type,
            'file_size_kb'   => $this->file_size_kb,

            // Signed URL — only generated for admins reviewing documents
            // Never expose raw file_path
            'signed_url' => $this->when(
                $isAdmin,
                function () {
                    try {
                        return app(KycService::class)->signedUrl($this->resource, 15);
                    } catch (\Throwable $e) {
                        return null;
                    }
                }
            ),

            'verified_at'      => $this->verified_at?->toIso8601String(),
            'rejection_reason' => $this->when(
                $isAdmin || $this->status === 'rejected',
                $this->rejection_reason
            ),

            'uploaded_at' => $this->created_at?->toIso8601String(),
        ];
    }
}