<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class storeInvestigationRequest extends FormRequest
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
        //title,des,dll yang di konvers dari complaint, jangan di tulis
        //kalau tidak nanti di abaikan
        return [
            'case_number' => 'required|string|max:50|unique:investigation_cases,case_number',
            'priority' => 'required|in:Low,Medium,High',
        ];
    }
    public function messages(): array
    {
        return [
            'case_number.required' => 'Nomor kasus harus diisi',
            'case_number.unique' => 'Nomor kasus sudah digunakan',
            'priority.required' => 'Priority harus diisi',
            'priority.in' => 'Priority hanya boleh Low, Medium, atau High',
        ];
    }
}
