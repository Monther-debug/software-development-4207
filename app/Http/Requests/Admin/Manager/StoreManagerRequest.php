<?php

namespace App\Http\Requests\Admin\Manager;

use Illuminate\Foundation\Http\FormRequest;

class StoreManagerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:managers',
            'phone_number' => 'required|string|unique:managers',
            'password' => 'required|string|min:6',
            'schoolID' => 'required|exists:schools,id',
        ];
    }
}
