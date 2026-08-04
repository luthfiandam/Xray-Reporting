<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role->name, ['Super Admin', 'Supervisor']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'equipment_id' => ['required', 'exists:equipments,id'],
            'maintenance_type_id' => ['required', 'exists:maintenance_types,id'],
            'maintenance_frequency_id' => ['required', 'exists:maintenance_frequencies,id'],
            'checklist_template_id' => ['required', 'exists:checklist_templates,id'],
            'assigned_to' => ['required', 'exists:users,id'],
            'priority' => ['required', Rule::in(['low', 'normal', 'high', 'critical'])],
            'scheduled_at' => ['nullable', 'date', 'after_or_equal:today'],
            'problem_description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'equipment_id.required' => 'Peralatan harus dipilih',
            'equipment_id.exists' => 'Peralatan tidak ditemukan',
            'maintenance_type_id.required' => 'Tipe maintenance harus dipilih',
            'maintenance_frequency_id.required' => 'Frekuensi maintenance harus dipilih',
            'checklist_template_id.required' => 'Template checklist harus dipilih',
            'assigned_to.required' => 'Teknisi harus dipilih',
            'priority.required' => 'Prioritas harus dipilih',
            'scheduled_at.date' => 'Format tanggal tidak valid',
        ];
    }
}