<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkedHourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|integer|exists:users,id',
            'company_id' => 'sometimes|integer|exists:companies,id',
            'hourly_rate_cents' => 'nullable|integer|min:0',
            'start_time' => 'sometimes|datetime',
            'stop_time' => 'sometimes|datetime|after:start_time',
            'description' => 'nullable|string|max:1000',
        ];
    }
}
