<?php

namespace App\Http\Requests;

use App\Models\SessionPoll;
use Illuminate\Foundation\Http\FormRequest;

class SubmitPollResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        // Dynamically validate that the selected option(s) exist in the poll
        $poll = $this->route('poll');

        $validOptions = $poll instanceof SessionPoll
            ? $poll->options
            : [];

        return [
            // Accepts either a single string or an array of strings
            // to support both single-choice and multi-choice polls
            'response'   => ['required'],
            'response.*' => ['string', 'in:' . implode(',', $validOptions)],
        ];
    }

    public function messages(): array
    {
        return [
            'response.required'  => 'You must select at least one option.',
            'response.*.in'      => 'One or more selected options are not valid for this poll.',
        ];
    }

    /**
     * Normalise response — always wrap in array for consistent handling.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('response') && ! is_array($this->response)) {
            $this->merge(['response' => [$this->response]]);
        }
    }
}