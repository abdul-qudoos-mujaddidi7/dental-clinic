<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
            "category_id" => $this->input("categoryId"),
            "stage_id"=> $this->input("stageId"),
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
            'name' => 'required|string',
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:Male,Female',
            'address' => 'nullable|string|max:255',
            'date' => 'required|date',
            'category_id' => 'required', 
            'stage_id' => 'required',
            'description' => 'nullable|string',
        ];
    }
}
