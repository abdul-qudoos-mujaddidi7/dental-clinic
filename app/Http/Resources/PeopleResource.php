<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;
use App\Models\SystemSetting;

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
            'dateOfBirth' => $this->date_of_birth ? $this->date_of_birth->diffInYears(now()) : null,
            'gender' => $this->gender,
            'medicalRecord' => $this->medical_record,
            'dentalRecord' => $this->dental_record,
            'status' => $this->status,
            'salary' => $this->salary,
            'position' => $this->position,
            'image' => $this->image,
            'share' => $this->share,
            'systemAddress' => SystemSetting::first()?->address,
            'systemPhone' => SystemSetting::first()?->phone,

        ];
    }
}

