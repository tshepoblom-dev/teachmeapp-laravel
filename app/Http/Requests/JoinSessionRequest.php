<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Both students and tutors can join — SessionService enforces
        // that only the booking parties can actually enter
        return $this->user() !== null;
    }

    public function rules(): array
    {
        // No body parameters required for join —
        // the session is identified by the route parameter
        // and the user is identified by their Sanctum token
        return [];
    }
}