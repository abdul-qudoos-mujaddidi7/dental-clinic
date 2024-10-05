<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerPickupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "id"=> $this->id,
            "date"=> $this->date,
            "amount"=> $this->amount,
            "description"=> $this->description,
            "owner"=> [
                "ownerID"=> $this->owner->id,
                "name"=> $this->owner->name,
            ],
                ];
    }
}
