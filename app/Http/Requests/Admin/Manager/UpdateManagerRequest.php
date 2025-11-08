<?php

namespace App\Http\Requests\Admin\Manager;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManagerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $managerId = $this->route('manager')->id ?? null;
        
        return [
            'name' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|unique:managers,username,' . $managerId,
            'phone_number' => 'sometimes|string|unique:managers,phone_number,' . $managerId,
            'password' => 'sometimes|string|min:6',
            'schoolID' => 'sometimes|exists:schools,id',
        ];
    }
}
