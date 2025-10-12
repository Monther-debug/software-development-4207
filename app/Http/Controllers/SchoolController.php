<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        return response()->json(School::latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'in:active,inactive',
            'type' => 'in:public,private',
            'level' => 'in:primary,secondary,tertiary',
        ]);

        $school = School::create($validated);

        return response()->json($school, 201);
    }

    public function show(School $school)
    {
        return response()->json($school);
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'in:active,inactive',
            'type' => 'in:public,private',
            'level' => 'in:primary,secondary,tertiary',
        ]);

        $school->update($validated);

        return response()->json($school);
    }

    public function destroy(School $school)
    {
        $school->delete();

        return response()->json(null, 204);
    }
}
