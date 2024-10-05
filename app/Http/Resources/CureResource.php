<?php

namespace App\Http\Resources;

use App\Models\CureService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'id' => $this->id,
            'patient' => [
                'id'=> $this->patient->id,
                'name'=> $this->patient->name,
            ],
            'start_date' => $this->start_date,
            'grand_total' => $this->grand_total,
            'paid' => $this->paid,
            'status' => $this->status,
            'description' => $this->description,
            'services' => CureServiceResource::collection($this->whenLoaded('cureServices')),

        ]
        ;
    }
}
