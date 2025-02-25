<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryDetailResource extends JsonResource
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
            'laboratoryId' => $this->laboratory_id,
            'toothId' => $this->tooth_id,
            'toothName'=>$this->tooth?->name,
            'cost' => $this->cost,
            'total' => $this->total,
            'quantity'=>$this->quantity,
            'status' => $this->status,
        ];
    }
}
