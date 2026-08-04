<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role->name, ['Super Admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'equipment_type_id' => ['required', 'exists:equipment_types,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'equipment_code' => ['required', 'string', 'max:50', 'unique:equipments,equipment_code'],
            'name' => ['required', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:50'],
            'model' => ['nullable', 'string', 'max:50'],
            'view_mode' => ['nullable', Rule::in(['single_view', 'dual_view', 'not_applicable'])],
            'serial_number' => ['required', 'string', 'max:100', 'unique:equipments,serial_number'],
            'generator_serial_a' => ['nullable', 'string', 'max:100'],
            'generator_serial_b' => ['nullable', 'string', 'max:100'],
            'detector_serial' => ['nullable', 'string', 'max:100'],
            'software_version' => ['nullable', 'string', 'max:50'],
            'firmware_version' => ['nullable', 'string', 'max:50'],
            'ip_address' => ['nullable', 'ip'],
            'installation_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['operational', 'maintenance', 'out_of_service'])],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'equipment_type_id.required' => 'Tipe peralatan harus dipilih',
            'equipment_type_id.exists' => 'Tipe peralatan tidak ditemukan',
            'location_id.required' => 'Lokasi harus dipilih',
            'location_id.exists' => 'Lokasi tidak ditemukan',
            'equipment_code.required' => 'Kode peralatan harus diisi',
            'equipment_code.unique' => 'Kode peralatan sudah terdaftar',
            'serial_number.required' => 'Serial number harus diisi',
            'serial_number.unique' => 'Serial number sudah terdaftar',
            'status.required' => 'Status harus dipilih',
        ];
    }
}