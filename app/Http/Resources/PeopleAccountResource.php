<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class PeopleAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "balance"=> $this->balance,
            "people"=> [
                'id' => $this->people ? $this->people->id : null,
                'name' => $this->people ? $this->people->name : null,
            ],
       
        ];
    }
}
