<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutboundLabRequest extends FormRequest
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
            "return_date" => $this->input("returnDate"),
            "grand_total" => $this->input("grandTotal"),
            "issue_at" => $this->input("issueAt"),
            "supplier_id" => $this->input("supplierId"),
            "money_account_id" => $this->input("moneyAccountId"),

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
            'return_date' => 'required|date',
            'issue_at' => 'required|date',
            'grand_total' => 'required|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'supplier_id' => 'nullable|exists:people,id',
            'money_account_id' => 'required|exists:money_accounts,id',
            'description' => 'nullable|string',
            'tooths' => 'required|array',
            'tooths.*.cost' => 'required|numeric', //te service details
            'tooths.*.toothId' => 'required|numeric', //te service details
            'tooths.*.quantity' => 'required|numeric', //ce details
            'tooths.*.total' => 'nullable|numeric', // Validate service details
            //
        ];
    }
}
