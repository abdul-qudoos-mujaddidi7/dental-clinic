<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
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
            "first_name"=> "required|string",
            "last_name"=> "required|string",
            "email"=> "required|unique:owners,email",
            "phone"=> "required|max:15",
            "share"=> "required|numeric",
            "image"=>"required|string"
        ];
    }
}
