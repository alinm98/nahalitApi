<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateWorkSampleRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'gallery_id' => ['required', 'exists:galleries,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'وارد کردن این فیلد الزامی میباشد',
            'max' => 'تعداد کاراکتر ها نباید بیشتر از :max باشد',
            'string' => 'فرمت اشتباه است',
            'gallery_id.exists' => 'گالری پیدا نشد',
            'category_id.exists' => 'دسته بندی پیدا نشد',
            'user_id.exists' => 'کاربر پیدا نشد',
        ];
    }
}
