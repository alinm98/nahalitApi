<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'min:3', 'max:30'],
            'last_name' => ['required', 'min:3', 'max:30'],
            'username' => ['required', 'min:3', 'max:60'],
            'mobile' => ['required', 'max:11', 'min:11'],
            'email' => ['required', 'email'],
            'code_meli' => ['integer', 'nullable', 'min:1', 'max:9999999999'],
            'card_number' => ['nullable', 'min:16', 'max:16'],
        ];
    }
}
