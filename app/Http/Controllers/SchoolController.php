<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;

class SchoolController extends Controller
{
    public function index()
    {
        return response()->json(School::latest()->get());
    }

    public function store(StoreSchoolRequest $request)
    {
        $validated = $request->validated();

        $school = School::create($validated);
        return response()->json($school, 201);
    }

    public function show(School $school)
    {
        return response()->json($school);
    }

    public function update(UpdateSchoolRequest $request, School $school)
    {
        $validated = $request->validated();

        $school->update($validated);

        return response()->json($school);
    }

    public function destroy(School $school)
    {
        $school->delete();

        return response()->json(null, 204);
    }
}
