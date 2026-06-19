<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadKycDocumentRequest extends FormRequest
{
    // Max file size in kilobytes (10 MB)
    private const MAX_SIZE_KB = 10240;

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'document_type' => [
                'required',
                'string',
                'in:national_id,passport,drivers_licence,selfie,proof_of_qualification,proof_of_address,other',
            ],
            'file' => [
                'required',
                'file',
                'max:' . self::MAX_SIZE_KB,
                'mimes:jpg,jpeg,png,pdf,heic',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'document_type.in' => 'Invalid document type. Accepted: national_id, passport, ' .
                'drivers_licence, selfie, proof_of_qualification, proof_of_address, other.',
            'file.max'         => 'File size must not exceed 10 MB.',
            'file.mimes'       => 'Accepted file formats: JPG, PNG, PDF, HEIC.',
            'file.required'    => 'Please select a file to upload.',
        ];
    }
}