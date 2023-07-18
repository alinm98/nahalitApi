<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username' => ['required', 'min:3', 'max:60', 'unique:users,username'],
            'mobile' => ['required', 'max:11', 'min:11', 'unique:users,mobile'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:32', 'confirmed'],
        ];
    }
}
