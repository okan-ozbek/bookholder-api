<?php

namespace app\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'company_id' => 'sometimes|integer|exists:companies,id',
            'client_id' => 'sometimes|integer|exists:companies,id',
            'status' => 'sometimes|string|in:' . implode(',', \App\Enums\InvoiceStatusEnum::values()),
            'from_time' => 'sometimes|datetime',
            'to_time' => 'sometimes|datetime|after:from_time',
            'due_time' => 'sometimes|datetime|after:to_time',
        ];
    }
}
