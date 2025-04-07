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
            "dentist_id"=>$this->input("dentistId"),
            "start_date"=> $this->input("startDate"),
            "grand_total"=> $this->input("grandTotal"),
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
        'patient_id' => 'required|exists:people,id',
        'dentist_id' => 'required|exists:people,id',
        'start_date' => 'required|date',
        'grand_total' => 'required|numeric|min:0',
        'paid' => 'nullable|numeric|min:0',
        'status' => 'required|string',
        'description' => 'nullable|string',
        'services' => 'nullable|array',
        'services.*.id' => 'nullable',
        'services.*.serviceId' => 'required',
        'services.*.cost' => 'required|numeric',
        'services.*.quantity'=>'required|numeric',
        'services.*.total' => 'nullable|numeric', 
        'services.*.status' => 'required|string'
    ];
}

    }
}
