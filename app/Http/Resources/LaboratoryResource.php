<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryResource extends JsonResource
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
            'return_date' => $this->start_date,
            'grand_total' => $this->grand_total,
            'paid' => $this->paid,
            'due'=> $due,
            // 'paymentStatus' => $this->getPaymentStatus(),
            'status' => $this->status,
            'description' => $this->description,
            // 'servicesDetails' => CureServiceResource::collection($this->whenLoaded('cureServices')),
        ];
    
}
}
