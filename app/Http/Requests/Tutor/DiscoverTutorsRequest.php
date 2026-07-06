<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

class DiscoverTutorsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search'         => ['nullable', 'string', 'max:255'],
            'institution_id' => ['nullable', 'integer', 'exists:institutions,id'],
            'subject_id'     => ['nullable', 'integer', 'exists:subjects,id'],
            'max_rate'       => ['nullable', 'numeric', 'min:0'],
            'min_rating'     => ['nullable', 'numeric', 'min:0', 'max:5'],
            'sort'           => ['nullable', 'in:rating,rate_asc,rate_desc'],
        ];
    }
}
