<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
            'date' => Carbon::parse($this->datetime)->format('Y-m-d'), 
            'time' => Carbon::parse($this->datetime)->format('H:i'), 
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
