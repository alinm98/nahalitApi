<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstallmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'price'=>['required','integer'],
            'description'=>['required','max:100'],
            'number_of_installment'=>['required','integer'],
            'status'=>['required'],
            'payments'=>['required'],
            'deadline'=>['required'],
        ];
    }
}
