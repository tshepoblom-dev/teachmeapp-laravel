<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
            ],
            // Students register freely; tutors must submit KYC next
            'role' => ['required', new Enum(UserRole::class), 'not_in:admin'],
            // Optional on registration — can be set via profile update
            'timezone' => ['sometimes', 'string', 'timezone:all'],
            // POPIA consent — both boxes must be explicitly ticked
            'terms_accepted'   => ['required', 'accepted'],
            'privacy_accepted' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'role.not_in' => 'The selected role is not permitted for self-registration.',
            'terms_accepted.required'  => 'You must accept the Terms of Service to continue.',
            'terms_accepted.accepted'  => 'You must accept the Terms of Service to continue.',
            'privacy_accepted.required'=> 'You must accept the Privacy Policy to continue.',
            'privacy_accepted.accepted'=> 'You must accept the Privacy Policy to continue.',     
        ];
    }
}
