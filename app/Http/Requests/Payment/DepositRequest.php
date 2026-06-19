<?php

namespace App\Http\Requests\Payment;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'amount'         => ['required', 'numeric', 'min:10', 'max:100000'],
            'payment_method' => ['required', 'string', 'exists:payment_methods,code'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            $code   = $this->input('payment_method');
            $amount = (float) $this->input('amount');

            $method = PaymentMethod::where('code', $code)->where('is_active', true)->first();

            if (! $method) {
                $v->errors()->add('payment_method', 'This payment method is not currently available.');
                return;
            }

            if ($method->min_amount && $amount < $method->min_amount) {
                $v->errors()->add('amount', "Minimum deposit for {$method->name} is {$method->min_amount}.");
            }

            if ($method->max_amount && $amount > $method->max_amount) {
                $v->errors()->add('amount', "Maximum deposit for {$method->name} is {$method->max_amount}.");
            }

            // Wallet balance cannot be used to deposit into itself
            if ($code === 'wallet_balance') {
                $v->errors()->add('payment_method', 'Wallet Balance cannot be used as a deposit method.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'amount.min'                 => 'Minimum deposit amount is R10.',
            'payment_method.exists'      => 'Invalid payment method selected.',
        ];
    }
}
