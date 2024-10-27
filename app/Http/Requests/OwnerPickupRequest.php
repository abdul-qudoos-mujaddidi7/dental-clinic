<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerPickupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function prepareForValidation(){
        return $this->merge([
            "owner_id"=> $this->input("ownerId"),
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
            "date" => "required|date", 
            "amount" => "required|numeric|min:0",
            "owner_id" => "required",
            "description" => "nullable|string",
        ];
        
    }
}
