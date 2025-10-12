<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        return response()->json(Manager::with('School')->latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:managers,email',
            'password' => 'required|string|min:8',
            'school_id' => 'required|exists:schools,id',
        ]);

        $manager = Manager::create($validated);

        return response()->json($manager->load('School'), 201);
    }

    public function show(Manager $manager)
    {
        return response()->json($manager->load('School'));
    }

    public function update(Request $request, Manager $manager)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:managers,email,'.$manager->id,
            'password' => 'sometimes|required|string|min:8',
            'school_id' => 'sometimes|required|exists:schools,id',
        ]);

        $manager->update($validated);

        return response()->json($manager->load('School'));
    }

    public function destroy(Manager $manager)
    {
        $manager->delete();

        return response()->json(null, 204);
    }
}
