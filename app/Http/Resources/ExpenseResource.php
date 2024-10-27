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
            'date'=>$this->date,
            'amount'=>$this->amount,
            'addedBy'=>$this->user->name,
            'reference'=> $this->reference,
            'expenseCategory'=>[
                'id' =>$this->expenseCategory->id,
                'name'=>$this->expenseCategory->name

            ]
        ];
    }
}
