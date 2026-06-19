<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminKycRejectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role->value === 'admin';
    }

    public function rules(): array
    {
        return [
            // Rejection reason is shown to the applicant — required and meaningful
            'reason' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],

            // Internal admin notes — never shown to applicant
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => 'A rejection reason is required so the applicant knows what to fix.',
            'reason.min'      => 'Please provide a meaningful rejection reason (at least 10 characters).',
        ];
    }
}