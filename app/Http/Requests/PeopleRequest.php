<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\People;

class PeopleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            People::COLUMN_DATE_OF_BIRTH => $this->input('dateOfBirth'),
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
            People::COLUMN_NAME => 'nullable|string|max:255',
            People::COLUMN_PHONE => 'nullable|string|max:20',
            People::COLUMN_EMAIL => 'nullable|email|unique:people,email,' . $this->id,
            People::COLUMN_ADDRESS => 'nullable|string|max:500',
            People::COLUMN_TYPE => 'required|in:patient,dentist,supplier,owner,employee,customer',
            People::COLUMN_DATE_OF_BIRTH => 'nullable|date',
            People::COLUMN_GENDER => 'nullable|in:Male,Female',
            People::COLUMN_MEDICAL_RECORD => 'nullable|json',
            People::COLUMN_DENTAL_RECORD => 'nullable|json',
            People::COLUMN_POSITION => 'nullable|string',
            People::COLUMN_SALARY => 'nullable|numeric|min:0',
            // 'status' => 'nullable|boolean',
            // 'doctor_warning' => 'nullable|string',
            // 'hire_date' => 'nullable|date',
            // 'image' => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            // 'share' => 'nullable|numeric|min:0|max:100',
        ];
    }
}
