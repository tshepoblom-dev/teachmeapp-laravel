<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // gate enforced at controller
    }

    public function rules(): array
    {
        return [
            'name'                     => ['sometimes', 'string', 'max:255', 'min:2'],
            'bio'                      => ['sometimes', 'nullable', 'string', 'max:2000'],
            'phone_number'             => ['sometimes', 'nullable', 'string', 'max:20'],
            'timezone'                 => ['sometimes', 'string', 'timezone:all'],
            'language_preference'      => ['sometimes', 'string', 'max:10'],
            // Tutor-only fields (ignored for students)
            'subjects'                 => ['sometimes', 'nullable', 'array'],
            'subjects.*'               => ['string', 'max:100'],
            'hourly_rate'              => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'is_available'             => ['sometimes', 'boolean'],
            'teaching_specializations' => ['sometimes', 'nullable', 'array'],
            'teaching_specializations.*' => ['string', 'max:100'],
            'education_level'          => ['sometimes', 'nullable', 'string', 'max:100'],
            'years_of_experience'      => ['sometimes', 'nullable', 'integer', 'min:0', 'max:60'],
            'institution_ids'          => ['sometimes', 'nullable', 'array'],
            'institution_ids.*'        => ['integer', 'exists:institutions,id'],
            'subject_ids'              => ['sometimes', 'nullable', 'array'],
            'subject_ids.*'            => ['integer', 'exists:subjects,id'],
        ];
    }
}
