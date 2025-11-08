<?php

namespace App\Http\Requests\Admin\School;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:female,male,uni_gender',
            'level' => 'required|in:primary,secondary,tertiary',
        ];
    }
}
