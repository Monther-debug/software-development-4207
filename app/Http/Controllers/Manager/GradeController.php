<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\Grade\StoreGradeRequest;
use App\Http\Requests\Manager\Grade\UpdateGradeRequest;
use App\Http\Resources\GradeResource;
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::all();
        return GradeResource::collection($grades);
    }

    public function store(StoreGradeRequest $request)
    {
        $grade = Grade::create($request->validated());
        return new GradeResource($grade);
    }

    public function show(Grade $grade)
    {
        return new GradeResource($grade);
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $grade->update($request->validated());
        return new GradeResource($grade);
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return response()->json(null, 204);
    }
}
