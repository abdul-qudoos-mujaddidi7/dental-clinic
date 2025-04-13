<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryResource extends JsonResource
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
            'people' => [
                'id'=> $this->people->id,
                'name'=> $this->people->name,
            ],
            'amount' => $this->amount,
            // 'paid_at' => $this->paid_at,
            // 'description' => $this->description,
        ];
    }
}
