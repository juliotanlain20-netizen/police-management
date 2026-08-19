<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InvestigationRequest extends FormRequest
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
        'case_number' => 'sometimes|required|string|max:50',
        'title' => 'sometimes|required|string|max:255',
        'description' => 'sometimes|required|string',
        'status' => 'sometimes|required|in:Open,In Progress,Closed',
        'priority' => 'sometimes|required|in:Low,Medium,High',
 
        ];
    }
     public function messages():array{
        return[
        'case_number' => 'harus string dan max 100 char',
        'title' => 'harus string dan maksimal 255 char',
        'description' => 'harus string',
        'status' => 'pilih cuman Open,In Progress,Closed',
        'priority' => 'pilih cuman Low,High,Mendium',
    ];}
}
