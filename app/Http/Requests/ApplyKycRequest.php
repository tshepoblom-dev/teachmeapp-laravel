<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyKycRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only tutors and students apply for KYC
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'application_type' => [
                'required',
                'string',
                'in:new_tutor,student_upgrade',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'application_type.in' => 'Application type must be either "new_tutor" or "student_upgrade".',
        ];
    }

    /**
     * Auto-resolve application type based on user role if not provided.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->has('application_type') && $this->user()) {
            $this->merge([
                'application_type' => $this->user()->role->value === 'tutor'
                    ? 'new_tutor'
                    : 'student_upgrade',
            ]);
        }
    }
}