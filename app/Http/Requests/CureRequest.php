<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CureRequest extends FormRequest
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
            "patient_id"=> $this->input("patientId"),
            "start_date"=> $this->input("startDate"),
            "grand_total"=> $this->input("grandTotal"),
            "diseases_history"=> $this->input("diseasesHistory"),
            "particular_to_female"=> $this->input("particularToFemale"),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
{
    return [
        'patient_id' => 'required|exists:patients,id',
        'start_date' => 'required|date',
        'grand_total' => 'required|numeric|min:0',
        'paid' => 'required|numeric|min:0',
        'status' => 'required|string',
        'description' => 'nullable|string',
        'diseases_history' => 'nullable|array', // Validate disease_history as JSON
        'particular_to_female' => 'nullable|array', // Validate disease_history as JSON
        'services' => 'nullable|array',        // Validate services array
        'services.*.serviceId' => 'required', // Validate each service name
        'services.*.cost' => 'nullable|numeric', // Validate service details
        'services.*.discount' => 'nullable|numeric', // Validate service details
        'services.*.total' => 'nullable|numeric', // Validate service details
        'services.*.status' => 'required|string' // Validate service details
    ];
}

    }
}
