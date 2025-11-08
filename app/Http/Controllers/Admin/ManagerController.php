<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = Manager::all();
        return response()->json($managers);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:managers',
            'phone_number' => 'required|string|unique:managers',
            'password' => 'required|string|min:6',
            'schoolID' => 'required|exists:schools,id',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $manager = Manager::create($validatedData);
        return response()->json($manager, 201);
    }

    public function show(Manager $manager)
    {
        return response()->json($manager);
    }

    public function update(Request $request, Manager $manager)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|unique:managers,username,' . $manager->id,
            'phone_number' => 'sometimes|string|unique:managers,phone_number,' . $manager->id,
            'password' => 'sometimes|string|min:6',
            'schoolID' => 'sometimes|exists:schools,id',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        $manager->update($validatedData);
        return response()->json($manager);
    }

    public function destroy(Manager $manager)
    {
        $manager->delete();
        return response()->json(null, 204);
    }
}
