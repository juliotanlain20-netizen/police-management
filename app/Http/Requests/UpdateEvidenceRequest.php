<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEvidenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'evidence_category_id' => [
                'required',
                'exists:evidence_categories,id',
            ],

            'evidence_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('evidences', 'evidence_code')
                    ->ignore($this->route('id')),
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'storage_location' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                Rule::in([
                    'Stored',
                    'Borrowed',
                    'Returned',
                    'Destroyed',
                ]),
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'evidence_category_id.required' => 'Kategori evidence harus dipilih.',
            'evidence_category_id.exists' => 'Kategori evidence tidak valid.',

            'evidence_code.required' => 'Evidence code harus diisi.',
            'evidence_code.unique' => 'Evidence code sudah digunakan.',
            'evidence_code.max' => 'Evidence code maksimal 50 karakter.',

            'name.required' => 'Nama evidence harus diisi.',
            'name.max' => 'Nama evidence maksimal 150 karakter.',

            'description.string' => 'Description harus berupa teks.',

            'storage_location.required' => 'Lokasi penyimpanan harus diisi.',
            'storage_location.max' => 'Lokasi penyimpanan maksimal 255 karakter.',

            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status evidence tidak valid.',
        ];
    }
}
