<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only tutors start sessions — SessionService enforces this
        return $this->user()?->role->value === 'tutor';
    }

    public function rules(): array
    {
        return [];
    }
}