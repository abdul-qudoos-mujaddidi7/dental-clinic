<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Models\People;
use App\Models\Currency;
use App\Models\PeopleAccount;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PeopleAccountRequest extends FormRequest
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
            PeopleAccount::COLUMN_NAME => [
                'nullable','string'
            ],
            
            PeopleAccount::COLUMN_PEOPLE_ID         => [
                'required',
                'integer',
                Rule::exists((new People())->getTable(), 'id')
            ],
            
        ];
    }
}
