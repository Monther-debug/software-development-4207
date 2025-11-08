<?php

namespace App\Http\Requests\Admin\School;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'address' => 'nullable|string',
            'status' => 'sometimes|in:active,inactive',
            'type' => 'sometimes|in:female,male,uni_gender',
            'level' => 'sometimes|in:primary,secondary,tertiary',
        ];
    }
}
