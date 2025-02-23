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
        'grand_total' => 'required|numeric|min:0',
        'paid' => 'nullable|numeric|min:0',
        'status' => 'required|string',
        'description' => 'nullable|string',
      
        'tooths' => 'nullable|array',        // Validate tooths array
        'tooths.*.id' => 'nullable', // Validate each service name
        'tooths.*.toothId' => 'required', // Validate each service name
        'tooths.*.cost' => 'required|numeric',//te service details
        'tooths.*.quantity'=>'required|numeric',//ce details
        'tooths.*.total' => 'nullable|numeric', // Validate service details
        'tooths.*.status' => 'required|string'
        ];
    }
}
