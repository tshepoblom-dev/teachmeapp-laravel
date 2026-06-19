<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role->value === 'admin';
    }

    public function rules(): array
    {
        $tierId = $this->route('tier')?->id;

        return [
            'name' => [
                'sometimes',
                'string',
                'max:100',
                Rule::unique('tutor_tiers', 'name')->ignore($tierId),
            ],
            'sessions_threshold' => [
                'sometimes',
                'integer',
                'min:0',
            ],
            'commission_rate' => [
                'sometimes',
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
                'sometimes',
                'string',
                'regex:/^#?[0-9A-Fa-f]{6}$/',
            ],
            'theme_colour_secondary' => [
                'sometimes',
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
                'sometimes',
                'boolean',
            ],
            'display_order' => [
                'sometimes',
                'integer',
                'min:0',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
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