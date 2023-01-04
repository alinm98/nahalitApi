<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceGroupRequest extends FormRequest
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
            'title' => ['required', 'unique:service_groups,title'],
            'service_group_id' => ['nullable', 'exists:service_groups,id'],
            'first_value' => ['required', 'integer'],
            'second_value' => ['nullable', 'integer'],
            'description' => ['nullable'],
            'services' => ['array'],
            'services.*' => ['exists:services,id'],
        ];
    }
}
