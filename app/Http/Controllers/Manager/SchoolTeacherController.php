<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolTeacherController extends Controller
{
    public function index(School $school)
    {
        $teachers = $school->teachers()->get();
        return response()->json($teachers);
    }

    public function store(Request $request, School $school)
    {
        $validatedData = $request->validate([
            'teacherID' => 'required|exists:teachers,id',
            'gradeID' => 'nullable|exists:grades,id',
        ]);

        $teacherId = $validatedData['teacherID'];
        $gradeId = $validatedData['gradeID'] ?? null;

        $school->teachers()->syncWithoutDetaching([$teacherId => ['gradeID' => $gradeId]]);

        return response()->json(['message' => 'Teacher assigned successfully.'], 201);
    }

    public function update(Request $request, School $school, Teacher $teacher)
    {
        $validatedData = $request->validate([
            'gradeID' => 'nullable|exists:grades,id',
        ]);

        if (isset($validatedData['gradeID'])) {
            $school->teachers()->updateExistingPivot($teacher->id, ['gradeID' => $validatedData['gradeID']]);
        }

        return response()->json(['message' => 'Teacher assignment updated successfully.']);
    }

    public function destroy(School $school, Teacher $teacher)
    {
        $school->teachers()->detach($teacher->id);
        return response()->json(null, 204);
    }
}
