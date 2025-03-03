<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Appointment;

class AppointmentRequest extends FormRequest
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
    public function prepareForValidation()
    {
        return $this->merge([
            Appointment::COLUMN_PATIENT_ID => $this->input('patientId'),
            Appointment::COLUMN_DENTIST_ID => $this->input('dentistId'),
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
            Appointment::COLUMN_DATE => 'required|date',
            Appointment::COLUMN_TIME => 'required|date_format:H:i',
            Appointment::COLUMN_STATUS => 'required|string',
            Appointment::COLUMN_DENTIST_ID => 'required|exists:people,id', // Ensure dentist exists
            Appointment::COLUMN_PATIENT_ID => 'required|exists:people,id',  // Ensure patient exists
        ];
    }
}
