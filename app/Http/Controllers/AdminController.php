<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\AdminResource;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('manager')->latest()->get();
        return AdminResource::collection($admins);
    }

    public function store(StoreAdminRequest $request)
    {
        $validated = $request->validated();

        $admin = Admin::create($validated);

        return (new AdminResource($admin->load('manager')))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Admin $admin)
    {
        return new AdminResource($admin->load('manager'));
    }

    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $validated = $request->validated();

        $admin->update($validated);

        return new AdminResource($admin->load('manager'));
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->json(null, 204);
    }
}
