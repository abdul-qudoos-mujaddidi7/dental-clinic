<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
                'last_name' => $this->last_name,
                'dateOfBirth' => $this->date_of_birth,
                'gender' => $this->gender,
                'diseasesHistory' => $this->diseases_history,
                'particularToFemale' => $this->particular_to_female,
                'doctorWarning' => $this->doctor_warning,
                'phone' => $this->phone,
            ];
    }
}
