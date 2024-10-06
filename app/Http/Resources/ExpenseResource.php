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
            'userId'=>$this->user_id,
            'expenseCategory'=>[
                $this->expenseCategory->id,
                $this->expenseCategory->name

            ]
        ];
    }
}
