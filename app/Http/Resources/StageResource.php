<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
<<<<<<< HEAD
            "id"=> $this->id??null,
            "name"=> $this->name??null,
=======
            "id"=> $this->id,
            "name"=> $this->name,
            "leadsCount"=> $this->leads_count,
>>>>>>> 96275de1913e234f81bb792c9d6b1d7b17a143bf
        ];
    }
}
