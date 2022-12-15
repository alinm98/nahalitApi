<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'title' => ['required', 'unique:products,title'],
            'price' => ['required', 'integer', 'min:1000'],
            'image' => ['required', 'mimes:png,jpg,peg,mpeg', 'min:1', 'max:2048'],
            'description' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}
