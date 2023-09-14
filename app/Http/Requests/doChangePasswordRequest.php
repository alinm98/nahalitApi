<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class doChangePasswordRequest extends FormRequest
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
            'mobile' => ['required', 'exists:users,mobile'],
            'new_password' => ['required', 'confirmed', 'min:8', 'max:32']
        ];
    }
}
