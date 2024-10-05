<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            "billExpense"=>$this->billExpense->id,
            "user"=>[
                "id"=> $this->user->id,
                "name"=> $this->user->name,
            ],

            
        ];
    }
}
