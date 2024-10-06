<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillExpenseRequest extends FormRequest
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
            "bill_number"=> $this->input("billNumber"),
            "bill_date"=> $this->input("billDate"),
            "grand_total"=> $this->input("grandTotal"),
            "supplier_id"=> $this->input("supplierId"),
            "billable_details'"=> $this->input("billableDetails'"),
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
            'bill_number' => 'required|string|unique:bill_expenses|max:255',
            'bill_date' => 'required|date',
            'paid' => 'required|numeric|between:0,99999999.99',
            'grand_total' => 'required|numeric|between:0,99999999.99',
            'note' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'billable_details' => 'required|array',
            'billable_details.*.productId' => 'required',
            'billable_details.*.quantity' => 'required|integer|min:1',
            'billable_details.*.cost' => 'required|numeric|between:0,999999.99',
            'billable_details.*.total' => 'required|numeric|between:0,999999.99',
        
        ];
        
    }
}
