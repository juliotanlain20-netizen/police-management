<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PoliceRequest extends FormRequest
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
        $rules = [
            'rank_id' => ['required', 'exists:ranks,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'nrp' => [
                'required',
                'string',
                'max:50',
                Rule::unique('police_officers', 'nrp')
                    ->ignore($this->route('id')),
            ],
            'address' => ['nullable', 'string', 'max:255'],
        ];

        if ($this->isMethod('post')) {
            $rules['user_id'] = [
                'required',
                'exists:users,id',
                'unique:police_officers,user_id',
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['status'] = [
                'required',
                Rule::in(['Active', 'Inactive']),
            ];
        }

        return $rules;
    }
    public function messages(): array
    {
        return [
            'rank_id.required' => 'Rank harus dipilih.',
            'rank_id.exists' => 'Rank yang dipilih tidak valid.',

            'user_id.required' => 'User harus dipilih.',
            'user_id.exists' => 'User yang dipilih tidak valid.',
            'user_id.unique' => 'User ini sudah terdaftar sebagai police.',

            'unit_id.required' => 'Unit harus dipilih.',
            'unit_id.exists' => 'Unit yang dipilih tidak valid.',

            'nrp.required' => 'NRP harus diisi.',
            'nrp.string' => 'NRP harus berupa teks.',
            'nrp.max' => 'NRP maksimal 50 karakter.',
            'nrp.unique' => 'NRP sudah digunakan.',

            'address.string' => 'Address harus berupa teks.',
            'address.max' => 'Address maksimal 255 karakter.',

            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status hanya boleh Active atau Inactive.',
        ];
    }
}
