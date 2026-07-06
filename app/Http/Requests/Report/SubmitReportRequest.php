<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class SubmitReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reason'       => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'action_taken' => ['required', 'in:continue_session,end_session'],
        ];
    }
}
