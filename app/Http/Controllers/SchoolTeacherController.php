<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Requests\AssignTeacherToSchoolRequest;
use App\Http\Requests\UpdateSchoolTeacherRequest;
use App\Http\Resources\SchoolTeacherResource;
use Symfony\Component\HttpFoundation\AcceptHeader;

class SchoolTeacherController extends Controller
{
    public function index(School $school)
    {
        $teachers = $school->teachers()->get();
        return SchoolTeacherResource::collection($teachers);
    }

    public function store(AssignTeacherToSchoolRequest $request, School $school)
    {
        $data = $request->validated();

        $teacherId = $data['teacherID'];
        $gradeId = $data['gradeID'];

        // attach; use syncWithoutDetaching to prevent duplicates
        $school->teachers()->syncWithoutDetaching([$teacherId => ['gradeID' => $gradeId]]);

        return response()->json(['message' => 'Teacher assigned successfully.']);
    }

    public function update(UpdateSchoolTeacherRequest $request, School $school, Teacher $teacher)
    {
       $data = $request->validated();

        $teacherId = $data['teacherID'];
        $gradeId = $data['gradeID'];

        // attach; use syncWithoutDetaching to prevent duplicates
        $school->teachers()->syncWithoutDetaching([$teacherId => ['gradeID' => $gradeId]]);
      
        ;
    }

    public function destroy(School $school, Teacher $teacher)
    {
        $school->teachers()->detach($teacher->id);
        return response()->json(null, 204);
    }
}
