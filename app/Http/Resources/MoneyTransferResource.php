<?php

namespace App\Http\Resources;


use App\Models\MoneyTransfer;
use Illuminate\Http\Resources\Json\JsonResource;

class MoneyTransferResource extends JsonResource
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
            "from_account"          => $this->fromAccount,
            "to_account"            => $this->toAccount,
            "amount"                => $this[MoneyTransfer::COLUMN_AMOUNT],
            "date"                  => $this[MoneyTransfer::COLUMN_DATE],
            "description"           => $this[MoneyTransfer::COLUMN_DESCRIPTION]
        ];
    }
}
