<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prePareForValidation()
    {
        return $this->merge([
            "patient_id" => $this->input("patientId"),
            "dentist_id" => $this->input("dentistId"),
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
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'status' => 'required|string',
            'dentist_id' => 'required|exists:people,id', // Ensure dentist exists
            'patient_id' => 'required|exists:people,id', // Ensure patient exists
        ];
    }
}
