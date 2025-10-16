<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManagerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $managerId = $this->route('manager') instanceof \App\Models\Manager
            ? $this->route('manager')->id
            : $this->route('manager');

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:managers,email,'.$managerId,
            'password' => 'sometimes|required|string|min:8',
            'school_id' => 'sometimes|required|exists:schools,id',
        ];
    }
}
