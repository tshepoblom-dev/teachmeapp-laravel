<?php

namespace App\Http\Requests\Payment;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class BookingPaymentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'payment_method' => ['required', 'string', 'exists:payment_methods,code'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            $code   = $this->input('payment_method');
            $method = PaymentMethod::where('code', $code)->where('is_active', true)->first();

            if (! $method) {
                $v->errors()->add('payment_method', 'This payment method is not currently available.');
            }
        });
    }
}
