<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmitWorkOrderRequest extends FormRequest
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
            'action_taken' => ['required', 'string', 'max:1000'],
            'final_condition' => ['required', Rule::in(['normal', 'limited', 'out_of_service'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'action_taken.required' => 'Tindakan yang diambil harus diisi',
            'final_condition.required' => 'Kondisi akhir harus dipilih',
        ];
    }
}