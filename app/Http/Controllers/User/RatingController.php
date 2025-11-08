<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::where('userID', auth('api')->id())->get();
        return response()->json($ratings);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'schoolID' => 'required|exists:schools,id',
            'rating' => 'required|in:1,2,3,4,5',
        ]);

        $validatedData['userID'] = auth('api')->id();
        $rating = Rating::create($validatedData);
        return response()->json($rating, 201);
    }

    public function show(Rating $rating)
    {
        if (auth('api')->id() !== $rating->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($rating);
    }

    public function update(Request $request, Rating $rating)
    {
        if (auth('api')->id() !== $rating->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'rating' => 'sometimes|in:1,2,3,4,5',
        ]);

        $rating->update($validatedData);
        return response()->json($rating);
    }

    public function destroy(Rating $rating)
    {
        if (auth('api')->id() !== $rating->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $rating->delete();
        return response()->json(null, 204);
    }
}
