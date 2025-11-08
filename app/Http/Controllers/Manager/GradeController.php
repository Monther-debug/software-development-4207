<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::all();
        return response()->json($grades);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        $grade = Grade::create($validatedData);
        return response()->json($grade, 201);
    }

    public function show(Grade $grade)
    {
        return response()->json($grade);
    }

    public function update(Request $request, Grade $grade)
    {
        $validatedData = $request->validate([
            'school_id' => 'sometimes|exists:schools,id',
            'name' => 'sometimes|string|max:255',
            'code' => 'sometimes|string|max:50',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $grade->update($validatedData);
        return response()->json($grade);
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return response()->json(null, 204);
    }
}
