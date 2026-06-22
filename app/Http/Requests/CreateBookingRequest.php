<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only students can create bookings
        return $this->user()?->role->value === 'student';
    }

    public function rules(): array
    {
        return [
            'tutor_id'         => ['required', 'integer', 'exists:users,id'],
            'subject'          => ['required', 'string', 'max:100'],
            'description'      => ['nullable', 'string', 'max:1000'],
            'scheduled_at'     => ['required', 'date', 'after:now'],
            'duration_minutes' => ['required', 'integer', 'min:60', 'max:480'],
            'payment_method_id'=> ['nullable', 'integer', 'exists:payment_methods,id'],

            // Optional — when student is rescheduling an existing booking
            'rescheduled_from_booking_id' => [
                'nullable',
                'integer',
                'exists:bookings,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tutor_id.exists'         => 'The selected tutor does not exist.',
            'scheduled_at.after'      => 'The session must be scheduled in the future.',
            'duration_minutes.min'    => 'Sessions must be at least 1 hour.',
            'duration_minutes.max'    => 'Sessions cannot exceed 8 hours.',
            'payment_method_id.exists'=> 'The selected payment method is not available.',
        ];
    }

    /**
     * Resolve the default payment method if none provided.
     * Falls back to: user preference → user default on users table → null
     */
    protected function prepareForValidation(): void
    {
        if (! $this->payment_method_id && $this->user()) {
            $default = $this->user()->default_payment_method_id
                ?? $this->user()
                    ->paymentMethodPreferences()
                    ->where('is_default', true)
                    ->value('payment_method_id');

            if ($default) {
                $this->merge(['payment_method_id' => $default]);
            }
        }
    }
}