<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'title' => ['required', 'unique:categories,title'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'property_groups' => ['array'],
            'property_groups.*' => ['exists:property_groups,id']
        ];
    }
}
