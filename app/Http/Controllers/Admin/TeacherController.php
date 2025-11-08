<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return response()->json($teachers);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
        ]);

        $teacher = Teacher::create($validatedData);
        return response()->json($teacher, 201);
    }

    public function show(Teacher $teacher)
    {
        return response()->json($teacher);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'subject' => 'sometimes|string|max:255',
            'experience' => 'sometimes|integer|min:0',
        ]);

        $teacher->update($validatedData);
        return response()->json($teacher);
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json(null, 204);
    }
}
