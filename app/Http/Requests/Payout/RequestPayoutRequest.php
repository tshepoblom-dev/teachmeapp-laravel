<?php

namespace App\Http\Requests\Payout;

use Illuminate\Foundation\Http\FormRequest;

class RequestPayoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role->value, ['tutor', 'student'], true);
    }

    public function rules(): array
    {
        return [
            'amount'            => ['required', 'numeric', 'min:50'],
            'payout_account_id' => ['required', 'exists:payout_accounts,id'],
        ];
    }
}
