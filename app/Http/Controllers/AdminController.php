<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(Admin::with('manager')->latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
            'manager_id' => 'nullable|exists:managers,id',
        ]);

        $admin = Admin::create($validated);

        return response()->json($admin->load('manager'), 201);
    }

    public function show(Admin $admin)
    {
        return response()->json($admin->load('manager'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:admins,email,'.$admin->id,
            'password' => 'sometimes|required|string|min:8',
            'manager_id' => 'nullable|exists:managers,id',
        ]);

        $admin->update($validated);

        return response()->json($admin->load('manager'));
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->json(null, 204);
    }
}
