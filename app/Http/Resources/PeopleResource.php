<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeopleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'type' => $this->type,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'medicalRecord' => $this->medical_record,
            'dentalRecord' => $this->dental_record,
            'status' => $this->status,
            'image' => $this->image,
            'share' => $this->share,
        ];
    }
}
