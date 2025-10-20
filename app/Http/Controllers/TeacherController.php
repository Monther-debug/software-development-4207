<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['school', 'grade'])->latest()->get();
        return TeacherResource::collection($teachers);
    }

    public function store(StoreTeacherRequest $request)
    {
        $teacher = Teacher::create($request->validated());
        return (new TeacherResource($teacher->load(['school', 'grade'])))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Teacher $teacher)
    {
        return new TeacherResource($teacher->load(['school', 'grade']));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());
        return new TeacherResource($teacher->load(['school', 'grade']));
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json(null, 204);
    }
}
