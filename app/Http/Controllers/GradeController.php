<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;

class GradeController extends Controller
{
    public function index()
    {
        return response()->json(Grade::with('school')->latest()->get());
    }

    public function store(StoreGradeRequest $request)
    {
        $grade = Grade::create($request->validated());
        return response()->json($grade->load('school'), 201);
    }

    public function show(Grade $grade)
    {
        return response()->json($grade->load('school'));
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $grade->update($request->validated());
        return response()->json($grade->load('school'));
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return response()->json(null, 204);
    }
}
