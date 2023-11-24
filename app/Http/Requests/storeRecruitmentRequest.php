<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeRecruitmentRequest extends FormRequest
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
            'first_name' => ['required', 'min:3', "max:50"],
            'last_name' => ['required', 'min:3', 'max:50'],
            'birthday' => ['required', 'date'],
            'martial_status' => ['required', 'boolean'],
            'address' => ['required','min:10', 'max:200'],
            'phone' => ['required', 'digits:11'],
            'activity' => ['required'],
            'eduction_status' => ['required'],
            'ability_description' => ['nullable'],
            'shaba_number' => ['required'],
            'status' => ['nullable', 'boolean'],
        ];
    }
}
