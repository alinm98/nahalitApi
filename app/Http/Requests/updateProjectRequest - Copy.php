<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateProjectRequest extends FormRequest
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
            'title' => ['required'],
            'user_id' => ['required', 'exists:users,id'],
            'supervisor_id' => ['required', 'exists:users,id'],
            'description' => ['required'],
            'price' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'file' => ['nullable', 'mimes:zip', 'max:50000'],
            'confirm' => ['required', 'boolean'],
            'status' => ['required', 'integer', 'min:1', 'max:3'],
            'progress' => ['required', 'integer', 'min:0', 'max:100'],
        ];
    }
}
