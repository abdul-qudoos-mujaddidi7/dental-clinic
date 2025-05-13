<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

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
            'dateOfBirth' => $this->date_of_birth 
                ? Jalalian::fromFormat('Y-m-d', $this->date_of_birth)->toCarbon()->diffInYears(now())
                : null,
            'gender' => $this->gender,
            'medicalRecord' => $this->medical_record,
            'dentalRecord' => $this->dental_record,
            'status' => $this->status,
            'salary' => $this->salary,
            'position' => $this->position,
            'image' => $this->image,
            'share' => $this->share,
        ];
    }
}

