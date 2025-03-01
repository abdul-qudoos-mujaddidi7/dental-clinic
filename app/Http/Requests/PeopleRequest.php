<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeopleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prePareForValidation(){
        return $this->merge([
            "date_of_birth"=> $this->input("dateOfBirth"),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:people,email,' . $this->id,
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:patient,dentist,supplier,owner,employee',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'diseases_history' => 'nullable|json',
            'particular_to_female' => 'nullable|json',
            'doctor_warning' => 'nullable|string',
            'status' => 'nullable|boolean',
            'hire_date' => 'nullable|date',
            'image' => 'nullable|string',
            'share' => 'nullable|numeric|min:0|max:100',
            'salary' => 'nullable|numeric|min:0',
        ];
    }
}
