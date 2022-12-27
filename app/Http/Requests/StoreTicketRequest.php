<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'title' => ['required', 'max:200'],
            'text' => ['required', 'string'],
            'author' => ['required', 'exists:users,id'],
            'to' => ['required', 'exists:users,id']
        ];
    }

    public function messages()
    {
        return [
            'required' => 'وارد کردن این فیلد الزامی میباشد',
            'max' => 'تعداد کاراکتر ها نباید بیشتر از :max باشد',
            'string' => 'فرمت اشتباه',
            'author.exists' => 'کاربر پیدا نشد',
            'to.exists' => 'کاربر پیدا نشد',
        ];
    }
}
