<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role->name === 'Super Admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:80', 'unique:users,username'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:32'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'technician_code' => ['nullable', 'string', 'max:50', 'unique:users,technician_code'],
            'status' => ['sometimes', 'in:active,inactive,suspended'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.max' => 'Nama maksimal 150 karakter',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah terdaftar di sistem',
            'username.max' => 'Username maksimal 80 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar di sistem',
            'email.max' => 'Email maksimal 150 karakter',
            'phone.max' => 'Nomor telepon maksimal 32 karakter',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'role_id.required' => 'Role wajib dipilih',
            'role_id.exists' => 'Role tidak valid',
            'technician_code.unique' => 'Kode teknisi sudah terdaftar',
            'technician_code.max' => 'Kode teknisi maksimal 50 karakter',
            'status.in' => 'Status tidak valid',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => strtolower(trim($this->username ?? '')),
            'email' => strtolower(trim($this->email ?? '')),
            'status' => $this->status ?? 'active',
        ]);
    }
}