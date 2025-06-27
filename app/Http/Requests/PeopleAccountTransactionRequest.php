<?php

namespace App\Http\Requests;

use App\Enums\OperationType;
use App\Enums\PaymentType;
use App\Enums\TransactionType;
use App\Models\CreditAccountTransaction;
use App\Models\People;
use App\Models\PeopleAccount;
use App\Models\PeopleAccountTransaction;
use App\Models\Currency;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PeopleAccountTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [

            PeopleAccountTransaction::COLUMN_PEOPLE_ID       => [
                'required',
                'integer',
            Rule::exists((new People())->getTable(), 'id')],

            PeopleAccountTransaction::COLUMN_AMOUNT       => [
                'required',
                'numeric',
            ],

            PeopleAccountTransaction::COLUMN_PARENT_RECORD_ID       => [
                'nullable',
                'integer',
            ],

            PeopleAccountTransaction::COLUMN_PAYMENT_TYPE            => [
                'nullable',
                'string',
                Rule::in(PaymentType::getValues())
            ],

            PeopleAccountTransaction::COLUMN_DESCRIPTION            => [
                'nullable',
                'string'
            ],

            PeopleAccountTransaction::COLUMN_DATE  => [
                'required',
                'date_format:Y-m-d'
            ],

        ];
    }


    public function messages()
    {
        return [
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 0.',
            'transaction_type.required' => 'The transaction type is required.',
            'transaction_type.string' => 'The transaction type must be a string.',
            'transaction_type.in' => 'The transaction type must be either credit or debit.',
            'datetime.required' => 'The datetime is required.',
            'datetime.date_format' => 'The datetime does not match the format Y-m-d H:i:s.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 255 characters.',
        ];
    }
}
