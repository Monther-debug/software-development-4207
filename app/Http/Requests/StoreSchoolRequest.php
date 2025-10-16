<?php

namespace App\Http\Requests;

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
            'address' => 'nullable|string|max:255',
            'status' => 'in:active,inactive',
            'type' => 'in:public,private',
            'level' => 'in:primary,secondary,tertiary',
        ];
    }
}
