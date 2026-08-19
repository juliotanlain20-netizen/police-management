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
            'category_id'=>'required|exists:complaint_categories,id',
            'title'=>'required',
            'description'=>'required',
            'location'=>'required',
            'incident_date'=>'required',
        ];
    }
    public function messages():array{
        return[
        'category.required'=>'category yang sesuai',
        'title.required'=>'judulnya di isi dong',
        'description.required'=>'isi rinciannya di sini',
        'location.required'=>'location harus di isi',
        'incident_date.required'=>'tanggal harus di isi',
    ];}
}
