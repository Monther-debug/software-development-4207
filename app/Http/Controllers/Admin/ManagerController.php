<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Manager\StoreManagerRequest;
use App\Http\Requests\Admin\Manager\UpdateManagerRequest;
use App\Http\Resources\ManagerResource;
use App\Models\Manager;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = Manager::all();
        return ManagerResource::collection($managers);
    }

    public function store(StoreManagerRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $manager = Manager::create($validatedData);
        return new ManagerResource($manager);
    }

    public function show(Manager $manager)
    {
        return new ManagerResource($manager);
    }

    public function update(UpdateManagerRequest $request, Manager $manager)
    {
        $validatedData = $request->validated();
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        $manager->update($validatedData);
        return new ManagerResource($manager);
    }

    public function destroy(Manager $manager)
    {
        $manager->delete();
        return response()->json(null, 204);
    }
}
