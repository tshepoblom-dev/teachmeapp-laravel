<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

class BulkAvailabilitySlotsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role->value === 'tutor';
    }

    public function rules(): array
    {
        return [
            'slots'                => ['required', 'array', 'min:1', 'max:50'],
            'slots.*.day_of_week'  => ['required', 'integer', 'min:0', 'max:6'],
            'slots.*.start_time'   => ['required', 'date_format:H:i'],
            'slots.*.end_time'     => ['required', 'date_format:H:i', 'after:slots.*.start_time'],
            'slots.*.is_recurring' => ['boolean'],
            'slots.*.valid_from'   => ['nullable', 'date'],
            'slots.*.valid_until'  => ['nullable', 'date'],
        ];
    }
}
