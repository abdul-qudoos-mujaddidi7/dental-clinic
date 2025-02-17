<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
    'date' => $this->date,
    'time' => $this->time,
    'status' => $this->status,
    // 'dentistName' => $this->dentist->name, 
    'userName' => $this->user->first_name,       
    // 'patientName' => $this->patient->name,
    'dentists' => [
        'id' => $this->dentist?->id,
        'name' => $this->dentist?->name,
    ],
    'patients' => [
        'id' => $this->patient?->id,
        'name' => $this->patient?->name,
    ]
];

    }
}
