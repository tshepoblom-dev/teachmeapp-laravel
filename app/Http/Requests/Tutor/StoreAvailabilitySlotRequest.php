<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

class StoreAvailabilitySlotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role->value === 'tutor';
    }

    public function rules(): array
    {
        return [
            'day_of_week'  => ['required', 'integer', 'min:0', 'max:6'],
            'start_time'   => ['required', 'date_format:H:i'],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'is_recurring' => ['boolean'],
            'valid_from'   => ['nullable', 'date'],
            'valid_until'  => ['nullable', 'date', 'after_or_equal:valid_from'],
        ];
    }
}
