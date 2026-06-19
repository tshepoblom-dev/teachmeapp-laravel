<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminDisputeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role->value === 'admin';
    }

    public function rules(): array
    {
        return [
            // action: 'release' pays the tutor | 'refund' returns funds to student
            'action' => ['required', 'string', 'in:release,refund'],
            'reason' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'action.in' => 'Dispute action must be either "release" (pay tutor) or "refund" (return to student).',
        ];
    }
}