<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class complaintRequest extends FormRequest
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
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240',
            'action' => 'required|in:save,submit',
            'category_id' => 'nullable|required_if:action,submit|exists:complaint_categories,id',
            'title' => 'nullable|required_if:action,submit|string|max:255',
            'description' => 'nullable|required_if:action,submit|string',
            'incident_date' => 'nullable|required_if:action,submit|date',
            'location' => 'nullable|required_if:action,submit|string',
        ];
    }
    public function messages(): array
    {
        return [
            'attachments.*.max' => 'Setiap attachment maksimal 10 MB.',
            'category.required' => 'category yang sesuai',
            'title.required' => 'judulnya di isi dong',
            'description.required' => 'isi rinciannya di sini',
            'location.required' => 'location harus di isi',
            'incident_date.required' => 'tanggal harus di isi',
        ];
    }
}
