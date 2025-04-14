<?php

namespace App\Http\Resources;

use App\Models\LaboratoryDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InboundLabResource extends JsonResource
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
            'returnDate' => $this->return_date,
            'issueAt' => $this->issue_at,
            'grandTotal' => $this->grand_total,
            'paid' => $this->paid,
            'dentist'=>[
                'id'=>$this->dentist?->id,
                'name'=>$this->dentist?->name
            ],
            // 'due'=> $due,
            // 'paymentStatus' => $this->getPaymentStatus(),
            'status' => $this->status,
            'description' => $this->description,
            'details' => LaboratoryDetailResource::collection($this->whenLoaded('mainLaboratoryDetails')),
        ];
    
}
}
