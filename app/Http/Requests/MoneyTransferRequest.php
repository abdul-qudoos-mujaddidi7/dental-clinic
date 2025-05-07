<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Enums\TranferType;
use App\Enums\TransferType;
use App\Models\MoneyAccount;
use App\Models\MoneyTransfer;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MoneyTransferRequest extends FormRequest
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
            MoneyTransfer::COLUMN_FROM_ACCOUNT_ID => [
                'required',
                'integer',
                Rule::exists((new MoneyAccount())->getTable(), 'id')
            ],

            MoneyTransfer::COLUMN_TO_ACCOUNT_ID => [
                'required',
                'integer',
                Rule::exists((new MoneyAccount())->getTable(), 'id')
            ],
            'amount' => [
                'required',
                'numeric',
            ],
            MoneyTransfer::COLUMN_DESCRIPTION => [
                'nullable',
                'string',
            ],
            MoneyTransfer::COLUMN_DATE => [
                'required',
                'date',
            ]
          

        ];
    }

}
