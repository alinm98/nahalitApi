<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSellerRequest extends FormRequest
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
            'card_number' => ['required', 'size:16'],
            'code_meli' => ['required', 'size:11'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'وارد کردن این فیلد الزمی میباشد',
            'size' => 'تعداد کاراکتر ها باید :size باشد',
            'user_id.exists' => 'فروشنده پیدا نشد'
        ];
    }
}
