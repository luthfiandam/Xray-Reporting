<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEvidenceRequest extends FormRequest
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
            'evidence_type' => ['required', Rule::in(['photo', 'video', 'document'])],
            'file' => ['required', 'file', 'max:20480', 'mimes:jpeg,png,jpg,pdf,mp4,mov'],
            'caption' => ['nullable', 'string', 'max:500'],
            'taken_at' => ['nullable', 'datetime'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'work_order_id.required' => 'Work order harus ada',
            'evidence_type.required' => 'Tipe evidence harus dipilih',
            'file.required' => 'File harus diunggah',
            'file.max' => 'Ukuran file tidak boleh lebih dari 20MB',
            'file.mimes' => 'Format file tidak didukung. Gunakan: jpeg, png, jpg, pdf, mp4, mov',
        ];
    }
}