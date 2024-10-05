<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillExpenseResource extends JsonResource
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
            'billNumber' => $this->bill_number,
            'supplier' => [
                'id' => $this->supplier->id,
                'name' => $this->supplier->name,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->first_name,
            ],
            'note' => $this->note,
            'date' => $this->bill_date, 
            'grandTotal' => $this->grand_total,
            'paid' => $this->paid,
            'due' => $this->grand_total - $this->paid, // Assuming this field exists
            'expenseDetails' => ExpenseDetailResource::collection($this->whenLoaded('billExpenseDetails')),
        ];
    }
}
