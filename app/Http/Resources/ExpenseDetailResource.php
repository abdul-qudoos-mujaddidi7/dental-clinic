<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
            return [
                'id' => $this->id,
                'billExpenseId' => $this->bill_expense_id,
                'productId' => $this->product->id, 
                'price' => $this->price,
                'quantity' => $this->quantity,
                'total' => $this->total,
            ];
    }
}
