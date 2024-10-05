<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
            return [
                'name' => 'required|string',
                'last_name' => 'required|string',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:Male,Female',
                'diseases_history' => 'nullable|array',
                'particular_to_female' => 'nullable|array',
                'doctor_warning' => 'nullable|string',
                'phone' => 'required|string|max:15', // Adjust max length as needed
            ];
    
    }
}
