<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServicesGroupRequest extends FormRequest
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
            'title' => ['required'],
            'services_group_id' => ['nullable', 'exists:services_groups,id'],
            'first_value' => ['required', 'integer'],
            'second_value' => ['nullable', 'integer'],
            'description' => ['nullable']
        ];
    }
}
