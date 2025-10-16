<?php

namespace App\Http\Requests;

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
            'name' => 'sometimes|required|string|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'in:active,inactive',
            'type' => 'in:public,private',
            'level' => 'in:primary,secondary,tertiary',
        ];
    }
}
