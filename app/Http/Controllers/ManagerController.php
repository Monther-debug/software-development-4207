<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;

class ManagerController extends Controller
{
    public function index()
    {
        return response()->json(Manager::with('School')->latest()->get());
    }

    public function store(StoreManagerRequest $request)
    {
        $validated = $request->validated();

        $manager = Manager::create($validated);

        return response()->json($manager->load('School'), 201);
    }

    public function show(string  $id)
 
    {
        $manager = Manager::with('School')->find($id);
        if (!$manager) {
            return response()->json(['message' => 'Manager not found'], 404);
        }
        return response()->json($manager);
    }

    public function update(UpdateManagerRequest $request, Manager $manager)
    {
        $validated = $request->validated();

        $manager->update($validated);

        return response()->json($manager->load('School'));
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
