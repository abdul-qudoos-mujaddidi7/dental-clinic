<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BillExpenseRequest extends FormRequest
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
            "bill_number" => $this->input("billNumber"),
            "bill_date" => $this->input("billDate"),
            "grand_total" => $this->input("grandTotal"),
            "supplier_id" => $this->input("supplierId"),
            "billable_details" => $this->input("expenseDetails"),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         // Get the bill expense ID from the route (assuming it's in the route)
    // dd($this->route('billExpense'));
        return [
            'bill_number' => [
                'required',
                'string',
                Rule::unique('bill_expenses')->ignore($this->route('billExpense') ? $this->route('billExpense')->id : null), // Ignore the current record
                'max:255'
            ],
            'bill_date' => 'required|date',
            'paid' => 'required|numeric|between:0,99999999.99',
            'grand_total' => 'required|numeric|between:0,99999999.99',
            'note' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',

            'billable_details' => 'required|array',
            'billable_details.*.id' => 'nullable',
            'billable_details.*.expenseProduct' => 'nullable',
            'billable_details.*.productId' => 'nullable',
            'billable_details.*.quantity' => 'required|integer|min:1',
            'billable_details.*.cost' => 'required|numeric|between:0,999999.99',
            'billable_details.*.total' => 'required|numeric|between:0,999999.99',
        ];
    }
}
