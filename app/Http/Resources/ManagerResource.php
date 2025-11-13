<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'email' => $this->email,
            'phone_number' => $this->phone_number,
            // Note: DB column is `schoolID` (capital D), not `schoolId`
            'schoolID' => $this->schoolID,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Relationship method is `school()`, so use lowercase here
            'school' => $this->whenLoaded('school'),
        ];
    }
}
