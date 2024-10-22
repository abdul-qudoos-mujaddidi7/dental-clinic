<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role= $this->roles->first();
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'phone' => $this->phone,
            'role'=> $role ?[
                'name'=> $role->name
            ] : null,
            'email' => $this->email,
            'status' => $this->status,
            "photoUrl" => $this->image ? asset("storage/" . $this->image) : null,
        ];
    }
}
