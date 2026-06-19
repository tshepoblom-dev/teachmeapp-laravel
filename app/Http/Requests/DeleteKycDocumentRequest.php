<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteKycDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // KycService enforces that only the document owner can delete
        return $this->user() !== null;
    }

    public function rules(): array
    {
        // No body parameters — document identified by route parameter
        return [];
    }
}