<?php

namespace app\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
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
            'company_id' => 'required|integer|exists:companies,id',
            'client_id' => 'required|integer|exists:companies,id',
            'status' => 'required|string|in:' . implode(',', \App\Enums\InvoiceStatusEnum::values()),
            'from_time' => 'required|datetime',
            'to_time' => 'required|datetime|after:from_time',
            'due_time' => 'required|datetime|after:to_time',
        ];
    }
}
