<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return response()->json($schools);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:female,male,uni_gender',
            'level' => 'required|in:primary,secondary,tertiary',
        ]);

        $school = School::create($validatedData);
        return response()->json($school, 201);
    }

    public function show(School $school)
    {
        return response()->json($school);
    }

    public function update(Request $request, School $school)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'nullable|string',
            'status' => 'sometimes|in:active,inactive',
            'type' => 'sometimes|in:female,male,uni_gender',
            'level' => 'sometimes|in:primary,secondary,tertiary',
        ]);

        $school->update($validatedData);
        return response()->json($school);
    }

    public function destroy(School $school)
    {
        $school->delete();
        return response()->json(null, 204);
    }
}
