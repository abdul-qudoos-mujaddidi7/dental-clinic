<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CureServiceResource extends JsonResource
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
            'cureId' => $this->cure_id,
            'serviceId' => $this->service_id,
            'serviceName'=>$this->service?->name,
            'cost' => $this->cost,
            'total' => $this->total,
            'status' => $this->status,
        ];
    }
}
