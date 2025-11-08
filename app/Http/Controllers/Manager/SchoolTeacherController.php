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
        // Ensure manager can only view their own school's teachers
        if ($school->id != auth('manager')->user()->schoolID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $teachers = $school->teachers()->get();
        return response()->json($teachers);
    }

    public function store(Request $request, School $school)
    {
        // Ensure manager can only assign teachers to their own school
        if ($school->id != auth('manager')->user()->schoolID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $validatedData = $request->validate([
            'teacherID' => 'required|exists:teachers,id',
            'gradeID' => 'required|exists:grades,id',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $teacherId = $validatedData['teacherID'];
        $gradeId = $validatedData['gradeID'];
        $year = $validatedData['year'];

        $school->teachers()->syncWithoutDetaching([
            $teacherId => [
                'gradeID' => $gradeId,
                'year' => $year
            ]
        ]);

        return response()->json(['message' => 'Teacher assigned successfully.'], 201);
    }

    public function update(Request $request, School $school, Teacher $teacher)
    {
        // Ensure manager can only update their own school's teacher assignments
        if ($school->id != auth('manager')->user()->schoolID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $validatedData = $request->validate([
            'gradeID' => 'sometimes|exists:grades,id',
            'year' => 'sometimes|integer|min:2000|max:2100',
        ]);

        $school->teachers()->updateExistingPivot($teacher->id, $validatedData);

        return response()->json(['message' => 'Teacher assignment updated successfully.']);
    }

    public function destroy(School $school, Teacher $teacher)
    {
        // Ensure manager can only remove teachers from their own school
        if ($school->id != auth('manager')->user()->schoolID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $school->teachers()->detach($teacher->id);
        return response()->json(null, 204);
    }
}
