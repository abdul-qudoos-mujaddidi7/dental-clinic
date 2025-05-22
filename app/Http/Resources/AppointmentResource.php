<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
            'date' => Jalalian::fromCarbon(Carbon::parse($this->date_time))->format('Y-m-d'), // Jalali formatted date
            'time' => $this->date_time ? Jalalian::fromCarbon(Carbon::parse($this->date_time))->format('H:i'):null, // Jalali formatted time
            'status' => $this->status,
            'userName' => $this->user?->first_name,
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
