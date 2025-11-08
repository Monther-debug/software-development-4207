<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\SuccessRating;
use Illuminate\Http\Request;

class SchoolSuccessRateController extends Controller
{
    public function index()
    {   
        $successRatings = auth('manager')->user()->school->successRatings;
        return response()->json($successRatings);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'gradeID' => 'required|exists:grades,id',
            'total_students' => 'required|integer|min:0',
            'A' => 'required|integer|min:0',
            'B' => 'required|integer|min:0',
            'C' => 'required|integer|min:0',
            'D' => 'required|integer|min:0',
        ]);

        $validatedData['schoolID'] = auth('manager')->user()->schoolID;
        $successRating = SuccessRating::create($validatedData);

        return response()->json($successRating, 201);
    }

    public function show($successRatingId)
    {
        $successRating = auth('manager')->user()->school->successRatings()->find($successRatingId);

        if (!$successRating) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json($successRating);
    }

    public function update(Request $request, $successRatingId)
    {
        $successRating = auth('manager')->user()->school->successRatings()->find($successRatingId);

        if (!$successRating) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $validatedData = $request->validate([
            'gradeID' => 'sometimes|exists:grades,id',
            'total_students' => 'sometimes|integer|min:0',
            'A' => 'sometimes|integer|min:0',
            'B' => 'sometimes|integer|min:0',
            'C' => 'sometimes|integer|min:0',
            'D' => 'sometimes|integer|min:0',
        ]);

        $successRating->update($validatedData);
        return response()->json($successRating);
    }

    public function destroy($successRatingId)
    {
        $successRating = auth('manager')->user()->school->successRatings()->find($successRatingId);

        if (!$successRating) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $successRating->delete();
        return response()->json(null, 204);
    }
}
