<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePollRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Both tutors and students can create polls during a session
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'question' => [
                'required',
                'string',
                'min:5',
                'max:255',
            ],
            'options'   => [
                'required',
                'array',
                'min:2',
                'max:6',
            ],
            'options.*' => [
                'required',
                'string',
                'max:100',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'options.min'    => 'A poll must have at least 2 options.',
            'options.max'    => 'A poll cannot have more than 6 options.',
            'options.*.max'  => 'Each poll option must be 100 characters or fewer.',
            'question.min'   => 'The poll question must be at least 5 characters.',
        ];
    }

    /**
     * Normalise options — trim whitespace and remove empty entries.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('options')) {
            $cleaned = collect($this->options)
                ->map(fn ($o) => trim($o))
                ->filter(fn ($o) => $o !== '')
                ->values()
                ->toArray();

            $this->merge(['options' => $cleaned]);
        }
    }
}