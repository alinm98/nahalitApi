<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
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
            'title' => ['required', 'max:100', 'min:3'],
            'body' => ['required', 'min:10'],
            'is_active' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,peg,mpeg', 'min:1', 'max:2048'],
        ];
    }
}
