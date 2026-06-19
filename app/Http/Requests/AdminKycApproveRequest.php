<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminKycApproveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role->value === 'admin';
    }

    public function rules(): array
    {
        return [
            // Internal notes — visible to admins only, never shown to applicant
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}