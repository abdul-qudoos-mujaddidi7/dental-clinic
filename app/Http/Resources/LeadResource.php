<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
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
            'name' => $this->name,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'note' => $this->note,
            'stage' => [
                'name' => $this->stage?->name ?? null,
                'id' => $this->stage?->id,
            ],
            'category' => [
                'name' => $this->category?->name,
                'id' => $this->category?->id
            ],
            'address' => $this->address,
            'date' => $this->date
        ];
    }
}