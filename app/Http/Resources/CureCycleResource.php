<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CureCycleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    
    public function toArray(Request $request): array
    {
    $appoinment=$this->cure->patient->appointments()->latest()->first();

        return [
            "id" => $this->id,
            "cure" => $this->cure->id,
            "appointment" => $appoinment->id,
        ];
    }
}
