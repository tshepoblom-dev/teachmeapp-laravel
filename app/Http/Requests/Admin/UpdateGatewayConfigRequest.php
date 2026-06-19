<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGatewayConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role->value === 'admin';
    }

    public function rules(): array
    {
        return [
            'environment' => ['required', 'in:sandbox,production'],
            'config'      => ['required', 'array'],
            'config.*'    => ['nullable', 'string', 'max:1000'],
        ];
    }
}
