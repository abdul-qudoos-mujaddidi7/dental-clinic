<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "phone"=> $this->phone,
            'totalAmount' => $this->totalAmount,
            // "lastName"=> $this->last_name,
            // "email"=> $this->email,
            // "image"=> $this->image,
            // "share"=> $this->share,
        ];
    }
}
