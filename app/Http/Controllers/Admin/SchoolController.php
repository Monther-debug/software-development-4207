<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\School\StoreSchoolRequest;
use App\Http\Requests\Admin\School\UpdateSchoolRequest;
use App\Http\Resources\SchoolResource;
use App\Models\School;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return SchoolResource::collection($schools);
    }

    public function store(StoreSchoolRequest $request)
    {
        $school = School::create($request->validated());
        return new SchoolResource($school);
    }

    public function show(School $school)
    {
        return new SchoolResource($school);
    }

    public function update(UpdateSchoolRequest $request, School $school)
    {
        $school->update($request->validated());
        return new SchoolResource($school);
    }

    public function destroy(School $school)
    {
        $school->delete();
        return response()->json(null, 204);
    }
}
