<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Grade;

class SchoolTeacherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $grade = null;
        if (isset($this->pivot) && isset($this->pivot->gradeID)) {
            $gradeModel = Grade::find($this->pivot->gradeID);
            if ($gradeModel) {
                $grade = new GradeResource($gradeModel);
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'subject' => $this->subject ?? null,
            'experience' => $this->experience ?? null,
            'grade' => $grade,
        ];
    }
}
