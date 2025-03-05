<?php

namespace App\Http\Resources;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPUnit\Event\Telemetry\System;

class SystemSettingResource extends JsonResource
{ 
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "address"=> $this->address,
            "phone"=> $this->phone,
            "photo" =>  $this[SystemSetting::COLUMN_IMAGE] ? asset("storage/" . $this[SystemSetting::COLUMN_IMAGE] ) : null,
            // This refers to the path of the photo stored in the database.
            //  If it exists, the asset() function will generate a URL for it.


        ];
        }
}
