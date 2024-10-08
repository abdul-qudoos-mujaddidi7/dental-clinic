<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemSettingResource extends JsonResource
{ 
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "address"=> $this->address,
            "photoUrl" => $this->image ? asset("storage/" . $this->image) : null,
            // This refers to the path of the photo stored in the database.
            //  If it exists, the asset() function will generate a URL for it.


        ];
        }
}
