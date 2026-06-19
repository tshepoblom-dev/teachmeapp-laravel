<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role->value === 'admin';
    }

    public function rules(): array
    {
        return [
            'tutor_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'tier_id' => [
                'required',
                'integer',
                'exists:tutor_tiers,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tutor_id.exists' => 'The selected tutor does not exist.',
            'tier_id.exists' => 'The selected tier does not exist.',
        ];
    }
}