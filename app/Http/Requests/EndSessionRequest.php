<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EndSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            // Optional reason — required if ending early (before scheduled end)
            'reason' => ['nullable', 'string', 'max:500'],
        ];
    }
}