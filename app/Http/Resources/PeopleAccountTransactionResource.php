<?php

namespace App\Http\Resources;
use Carbon\Carbon;

use App\Models\PeopleAccountTransaction;
use Illuminate\Http\Resources\Json\JsonResource;

class PeopleAccountTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id"                => $this[PeopleAccountTransaction::COLUMN_ID],
            "amount"              => $this[PeopleAccountTransaction::COLUMN_AMOUNT],
            "balance"           => $this[PeopleAccountTransaction::COLUMN_BALANCE],
            "payment_type"      => $this[PeopleAccountTransaction::COLUMN_PAYMENT_TYPE],

            "people" => [
                'id' => $this->people ? $this->people->id : NULL,
                'name'  => $this->people ? $this->people->name : NULL,
            ],
           'date' => Carbon::parse($this[PeopleAccountTransaction::COLUMN_DATE])->format('Y-m-d'),

            'description' => $this[PeopleAccountTransaction::COLUMN_DESCRIPTION],
        ];
    }
}
