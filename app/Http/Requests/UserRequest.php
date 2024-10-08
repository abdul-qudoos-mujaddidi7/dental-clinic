<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "first_name" => $this->input("firstName"),
            "last_name" => $this->input("lastName"),
            "role_id" => $this->input("roleId"),
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'status' => 'required|boolean',
            'email' => 'required|email|unique:users,email',
            'image' => 'nullable|file',
            'role_id' => 'required|numeric|exists:roles,id'
        ];
    }
}
