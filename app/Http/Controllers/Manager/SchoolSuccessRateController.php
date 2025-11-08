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
            'year' => 'required|integer|min:2000|max:2100',
            'success_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
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
            'year' => 'sometimes|integer|min:2000|max:2100',
            'success_rate' => 'sometimes|numeric|min:0|max:100',
            'notes' => 'nullable|string',
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
