<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolTeacherController extends Controller
{
    public function index()
    {
        // Get the manager's school automatically
        $manager = auth('manager')->user();
        if (! $manager || ! $manager->schoolID) {
            return response()->json(['error' => 'School not found for manager'], 404);
        }

        $school = School::find($manager->schoolID);
        if (! $school) {
            return response()->json(['error' => 'School not found'], 404);
        }

        $teachers = $school->teachers()->get();
        return response()->json($teachers);
    }

    public function store(Request $request)
    {
        $manager = auth('manager')->user();
        if (! $manager || ! $manager->schoolID) {
            return response()->json(['error' => 'School not found for manager'], 404);
        }

        $school = School::find($manager->schoolID);
        if (! $school) {
            return response()->json(['error' => 'School not found'], 404);
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

    public function update(Request $request, Teacher $teacher)
    {
        $manager = auth('manager')->user();
        if (! $manager || ! $manager->schoolID) {
            return response()->json(['error' => 'School not found for manager'], 404);
        }

        $school = School::find($manager->schoolID);
        if (! $school) {
            return response()->json(['error' => 'School not found'], 404);
        }

        $validatedData = $request->validate([
            'gradeID' => 'sometimes|exists:grades,id',
            'year' => 'sometimes|integer|min:2000|max:2100',
        ]);

        $school->teachers()->updateExistingPivot($teacher->id, $validatedData);

        return response()->json(['message' => 'Teacher assignment updated successfully.']);
    }

    public function destroy(Teacher $teacher)
    {
        $manager = auth('manager')->user();
        if (! $manager || ! $manager->schoolID) {
            return response()->json(['error' => 'School not found for manager'], 404);
        }

        $school = School::find($manager->schoolID);
        if (! $school) {
            return response()->json(['error' => 'School not found'], 404);
        }

        $school->teachers()->detach($teacher->id);
        return response()->json(null, 204);
    }
}
