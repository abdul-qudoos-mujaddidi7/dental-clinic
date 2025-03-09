<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaboratoryRequest extends FormRequest
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
            "return_date" => $this->input("returnDate"),
            "grand_total" => $this->input("grandTotal"),
            "issue_at" => $this->input("issueAt"),
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
            'return_date' => 'required|date',
            'issue_at' => 'required|date',
            'grand_total' => 'required|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'type'=>'required| in:in,out',
            'dentist_id' => 'nullable|exists:people,id',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'tooths' => 'required|array',
            'tooths.*.cost' => 'required|numeric', //te service details
            'tooths.*.name' => 'required|string', //te service details
            'tooths.*.quantity' => 'required|numeric', //ce details
            'tooths.*.total' => 'nullable|numeric', // Validate service details
        ];
    }
}
