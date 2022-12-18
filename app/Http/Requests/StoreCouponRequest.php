<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'coupon_type' => ['required', 'in:dollar,rial,percent'],
            'coupon_value' => ['required', 'integer'],
            'user_id' => ['required', 'exists:users,id']
        ];
    }

    public function messages():array
    {
        return [
            'required' => 'وارد کردن این فیلد الزامی میباشد',
            'in' => 'گزینه مورد نظر معتبر نمیباشد',
            'integer' => 'مقدار وارد شده باید عدد باشد',
            'user_id.exists' => 'کاربر پیدا نشد'
        ];
    }
}
