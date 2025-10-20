<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Http\Resources\ManagerResource;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = Manager::with('School')->latest()->get();
        return ManagerResource::collection($managers);
    }

    public function store(StoreManagerRequest $request)
    {
        $validated = $request->validated();

        $manager = Manager::create($validated);

        return (new ManagerResource($manager->load('School')))
            ->response()
            ->setStatusCode(201);
    }

    public function show(string  $id)
 
    {
        $manager = Manager::with('School')->find($id);
        if (!$manager) {
            return response()->json(['message' => 'Manager not found'], 404);
        }
        return new ManagerResource($manager);
    }

    public function update(UpdateManagerRequest $request, Manager $manager)
    {
        $validated = $request->validated();

        $manager->update($validated);

        return new ManagerResource($manager->load('School'));
    }

    public function destroy(string  $id)

    {
        
        $manager = Manager::find($id);
        if (!$manager) {
            return response()->json(['message' => 'Manager not found'], 404);
        }
        
        $manager->delete();
        return response()->json(null, 204);
    }
}
