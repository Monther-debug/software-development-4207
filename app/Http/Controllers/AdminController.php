<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(Admin::with('manager')->latest()->get());
    }

    public function store(StoreAdminRequest $request)
    {
        $validated = $request->validated();

        $admin = Admin::create($validated);

        return response()->json($admin->load('manager'), 201);
    }

    public function show(Admin $admin)
    {
        return response()->json($admin->load('manager'));
    }

    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $validated = $request->validated();

        $admin->update($validated);

        return response()->json($admin->load('manager'));
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->json(null, 204);
    }
}
