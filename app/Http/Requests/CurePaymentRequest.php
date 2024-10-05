<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurePaymentRequest extends FormRequest
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
            "cure_id"=> $this->input("cureId")
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
            'cure_id' => 'required|exists:cures,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ];
    }
}
