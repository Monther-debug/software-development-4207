<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTeacherToSchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'teacherID' => 'required|exists:teachers,id',
            'gradeID' => 'required|exists:grades,id',
        ];
    }
}
