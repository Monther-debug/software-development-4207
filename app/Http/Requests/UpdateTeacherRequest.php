<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teacherId = $this->route('teacher') instanceof \App\Models\Teacher
            ? $this->route('teacher')->id
            : $this->route('teacher');

        return [
            'school_id' => 'sometimes|required|exists:schools,id',
            'grade_id' => 'nullable|exists:grades,id',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:teachers,email,'.$teacherId,
            'password' => 'sometimes|required|string|min:8',
        ];
    }
}
