<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
        //dd($this->toArray());
        return [
            'total' => ['required', 'integer'],
            'user_id' => ['required', 'exists:users,id'],
            'products' => ['array', 'required'],
            //'products.*' => ['exists:products,id']
        ];
    }
}
