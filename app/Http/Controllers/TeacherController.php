<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;

class TeacherController extends Controller
{
    public function index()
    {
        return response()->json(Teacher::with(['school', 'grade'])->latest()->get());
    }

    public function store(StoreTeacherRequest $request)
    {
        $teacher = Teacher::create($request->validated());
        return response()->json($teacher->load(['school', 'grade']), 201);
    }

    public function show(Teacher $teacher)
    {
        return response()->json($teacher->load(['school', 'grade']));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());
        return response()->json($teacher->load(['school', 'grade']));
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json(null, 204);
    }
}
