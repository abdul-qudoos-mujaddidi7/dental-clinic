<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            'date'=>$this->date,
            'amount'=>$this->amount,
            'addedBy'=>$this->user?->first_name,
            'reference'=> $this->reference,
            'note'=> $this->note,
            'expenseCategory'=>[
                'id' =>$this->expenseCategory->id,
                'name'=>$this->expenseCategory->name

            ]
        ];
    }
}
