<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            "expense_category_id"=> $this->input("expenseCategoryId"),
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
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0', // Ensures 'amount' is present, a numeric value, and non-negative
            'expense_category_id' => 'required|exists:expense_categories,id', // Ensures 'expense_category_id' is present and exists in the 'expense_categories' table
        ];
    }
}
