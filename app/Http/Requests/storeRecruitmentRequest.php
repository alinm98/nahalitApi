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
            'birthday' => ['required', 'date'],
            'martial_status' => ['required', 'boolean'],
            'address' => ['required','min:10', 'max:200'],
            'activity' => ['required'],
            'eduction_status' => ['required'],
            'ability_description' => ['nullable'],
            'shaba_number' => ['required', 'digits:24'],
            'status' => ['nullable', 'in:waiting,rejected,accepted'],
            'card_number' => ['required', 'digits:16'],
            'code_meli' => ['required', 'digits:10'],
            'user_id' => ['required', 'exists:users,id']
        ];
    }
}
