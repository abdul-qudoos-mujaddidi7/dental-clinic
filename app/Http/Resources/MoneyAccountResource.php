<?php

namespace App\Http\Resources;

use App\Models\MoneyAccount;
use Illuminate\Http\Resources\Json\JsonResource;

class MoneyAccountResource extends JsonResource
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
            "id"                => $this->id,
            "name"              => $this[MoneyAccount::COLUMN_NAME],
            "balance"           => $this[MoneyAccount::COLUMN_BALANCE],
            
        ];
    }
}
