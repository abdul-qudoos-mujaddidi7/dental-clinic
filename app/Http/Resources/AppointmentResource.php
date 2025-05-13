<?php

namespace App\Http\Resources;

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
        try {
            // Parse the Jalali datetime stored in the database
            $jalali = Jalalian::fromFormat('Y-m-d H:i:s', $this->date_time);
            
            // Format the date and time in Jalali
            $date = $jalali->format('Y-m-d'); // 1404-02-03
            $time = $jalali->format('H:i');   // 05:51
        } catch (\Exception $e) {
            // In case of any error, set default values
            $date = null;
            $time = null;
        }

        return [
            'id' => $this->id,
            'dateTime' => $this->date_time, // Original datetime (Jalali format)
            'date' => $date, // Jalali formatted date
            'time' => $time, // Jalali formatted time
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
