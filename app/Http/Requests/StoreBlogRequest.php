<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'image' => ['required', 'mimes:png,jpg,peg,mpeg', 'min:16', 'max:2048'],
            'body' => ['required', 'min:20'],
            'user_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['required', 'boolean']
        ];
    }

    public function messages()
    {
        return [
            'required' => 'وارد کردن این فیلد الزامی است',
            'max' => 'تعداد کاراکتر ها نباید بیشتر از :max باشد',
            'min' => 'تعداد کاراکتر ها نباید کمتر از :min باشد',
            'user_id.exists' => 'کاربر پیدا نشد',
        ];
    }
}
