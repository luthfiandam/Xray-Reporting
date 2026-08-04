<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChecklistResultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'work_order_id' => ['required', 'exists:work_orders,id'],
            'checklist_template_item_id' => ['required', 'exists:checklist_template_items,id'],
            'result_status' => ['required', Rule::in(['ok', 'not_ok', 'not_applicable'])],
            'value_text' => ['nullable', 'string', 'max:500'],
            'value_number' => ['nullable', 'numeric'],
            'value_json' => ['nullable', 'json'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'work_order_id.required' => 'Work order harus ada',
            'checklist_template_item_id.required' => 'Item checklist harus dipilih',
            'result_status.required' => 'Status hasil harus dipilih',
        ];
    }
}