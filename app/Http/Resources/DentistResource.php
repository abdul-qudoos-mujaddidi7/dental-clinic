<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DentistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "id"=> $this->id,
            "firstName"=> $this->first_name,
            "lastName"=> $this->last_name,
            "email"=> $this->email,
            "phone"=> $this->phone,
            "address"=> $this->address,
            "hireDate"=> $this->hire_date,
            "image"=> $this->image? asset("storage/". $this->image) : null,
            "status"=> $this->status
        ];
    }
}
