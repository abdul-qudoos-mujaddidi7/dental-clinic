<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

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
            'dateTime' => $this->date_time,  
            'date' => Jalalian::fromFormat('Y-m-d H:i:s', $this->date_time)->format('Y/m/d'), // Extract only Jalali date
            'time' => Jalalian::fromFormat('Y-m-d H:i:s', $this->date_time)->format('H:i'),
            'status' => $this->status,
            'userName' => $this->user->first_name,
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
