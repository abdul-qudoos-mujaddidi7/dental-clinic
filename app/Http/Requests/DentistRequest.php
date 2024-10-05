<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DentistRequest extends FormRequest
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
            "first_name"=> $this->input("firstName"),
            "last_name"=> $this->input("lastName"),
            "hire_date"=> $this->input("hireDate"),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:dentists,email',
            'image' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'hire_date' => 'required|date',
        ];
    }
}
