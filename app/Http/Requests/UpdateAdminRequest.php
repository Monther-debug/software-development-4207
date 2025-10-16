<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adminId = $this->route('admin') instanceof \App\Models\Admin
            ? $this->route('admin')->id
            : $this->route('admin');

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:admins,email,'.$adminId,
            'password' => 'sometimes|required|string|min:8',
            'manager_id' => 'nullable|exists:managers,id',
        ];
    }
}
