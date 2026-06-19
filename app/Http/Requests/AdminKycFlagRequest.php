<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminKycFlagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role->value === 'admin';
    }

    public function rules(): array
    {
        // No body parameters required — action is implied by the endpoint
        return [];
    }
}