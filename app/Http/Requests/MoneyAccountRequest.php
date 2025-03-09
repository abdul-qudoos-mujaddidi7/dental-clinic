<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\MoneyAccount;

class MoneyAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            MoneyAccount::COLUMN_NAME => 'required|string',
            MoneyAccount::COLUMN_BALANCE => 'required|numeric',
        ];
    }
}