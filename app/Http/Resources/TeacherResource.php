<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'email' => $this->email,
            // 'school_id' => $this->school_id,
            // 'grade_id' => $this->grade_id,
            // 'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'school' => $this->whenLoaded('school'),
            'grade' => $this->whenLoaded('grade'),
        ];
    }
}
