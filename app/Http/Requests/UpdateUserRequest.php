<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->route('user');
        return $this->user() && $this->user()->can('update', $user);
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;
        $isSuperAdmin = $this->user()->role->name === 'Super Admin';

        return [
            'name' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:80', Rule::unique('users')->ignore($userId)],
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($userId)],
            'phone' => ['nullable', 'string', 'max:32'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['nullable', 'string'],
            'role_id' => [$isSuperAdmin ? 'required' : 'nullable', 'integer', 'exists:roles,id'],
            'technician_code' => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($userId)],
            'status' => [$isSuperAdmin ? 'sometimes' : 'nullable', 'in:active,inactive,suspended'],
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
        ]);

        if ($this->user()->role->name !== 'Super Admin') {
            $this->offsetUnset('role_id');
            $this->offsetUnset('status');
        }

        if (empty($this->password)) {
            $this->offsetUnset('password');
            $this->offsetUnset('password_confirmation');
        }
    }
}