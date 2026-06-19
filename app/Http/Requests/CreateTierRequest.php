<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role->value === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:tutor_tiers,name',
            ],
            'sessions_threshold' => [
                'required',
                'integer',
                'min:0',
            ],
            'commission_rate' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'bonus_rate_above_threshold' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],
            'theme_colour_primary' => [
                'required',
                'string',
                'regex:/^#?[0-9A-Fa-f]{6}$/',
            ],
            'theme_colour_secondary' => [
                'required',
                'string',
                'regex:/^#?[0-9A-Fa-f]{6}$/',
            ],
            'badge_icon_url' => [
                'nullable',
                'url',
                'max:255',
            ],
            'features' => [
                'nullable',
                'array',
            ],
            'features.*' => [
                'string',
                'max:100',
            ],
            'is_active' => [
                'boolean',
            ],
            'display_order' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique'                    => 'A tier with this name already exists.',
            'theme_colour_primary.regex'     => 'Primary colour must be a valid hex code (e.g. #CD7F32).',
            'theme_colour_secondary.regex'   => 'Secondary colour must be a valid hex code.',
            'sessions_threshold.min'         => 'Session threshold cannot be negative.',
            'commission_rate.min'            => 'Commission rate cannot be negative.',
            'commission_rate.max'            => 'Commission rate cannot exceed 100%.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Normalise hex colours — strip leading # for storage
        if ($this->has('theme_colour_primary')) {
            $this->merge([
                'theme_colour_primary' => ltrim($this->theme_colour_primary, '#'),
            ]);
        }

        if ($this->has('theme_colour_secondary')) {
            $this->merge([
                'theme_colour_secondary' => ltrim($this->theme_colour_secondary, '#'),
            ]);
        }
    }
}