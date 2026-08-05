<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role->name === 'Super Admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama role wajib diisi',
            'name.unique' => 'Nama role sudah terdaftar',
            'name.max' => 'Nama role maksimal 50 karakter',
            'description.max' => 'Deskripsi maksimal 255 karakter',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => strtoupper(trim($this->name ?? '')),
            'is_active' => $this->has('is_active') ? true : false,
        ]);
    }
}