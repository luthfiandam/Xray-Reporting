<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMeasurementResultRequest extends FormRequest
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
            'measurement_template_id' => ['required', 'exists:measurement_templates,id'],
            'ocr_result_id' => ['nullable', 'exists:ocr_results,id'],
            'ocr_value' => ['nullable', 'numeric'],
            'manual_value' => ['nullable', 'numeric'],
            'input_source' => ['required', Rule::in(['manual', 'ocr', 'ocr_edited'])],
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
            'measurement_template_id.required' => 'Template pengukuran harus dipilih',
            'input_source.required' => 'Sumber input harus dipilih',
        ];
    }
}