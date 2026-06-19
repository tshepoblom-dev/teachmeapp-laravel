<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendChatMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'message' => [
                'required_without:attachments',
                'nullable',
                'string',
                'max:2000',
            ],
            'attachments'   => ['nullable', 'array', 'max:5'],
            'attachments.*' => [
                'string',
                'url',
                'max:500',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required_without' => 'A message or at least one attachment is required.',
            'attachments.max'          => 'You may not send more than 5 attachments at once.',
            'attachments.*.url'        => 'Each attachment must be a valid URL.',
        ];
    }
}