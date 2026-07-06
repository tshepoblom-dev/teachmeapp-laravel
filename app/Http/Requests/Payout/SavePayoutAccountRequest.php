<?php

namespace App\Http\Requests\Payout;

use Illuminate\Foundation\Http\FormRequest;

class SavePayoutAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role->value, ['tutor', 'student'], true);
    }

    public function rules(): array
    {
        return [
            'account_type'        => ['required', 'in:bank,payfast,paypal'],
            'account_holder_name' => ['required', 'string', 'max:255'],
            'account_number'      => ['required_if:account_type,bank', 'nullable', 'string'],
            'branch_code'         => ['required_if:account_type,bank', 'nullable', 'string', 'max:10'],
            'bank_name'           => ['required_if:account_type,bank', 'nullable', 'string', 'max:100'],
            'is_default'          => ['boolean'],
        ];
    }
}
