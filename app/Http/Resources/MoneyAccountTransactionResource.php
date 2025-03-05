<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class MoneyAccountTransactionResource extends JsonResource
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
            "id"                    => $this->id,
            "money_account"         => $this->moneyAccount,
            "people"                => $this->people,
            "amount"                => $this->amount,
            "operation"             => $this->operation,
            "description"           => $this->description,
            "date"                  => $this->date,
        ];
    }
}
