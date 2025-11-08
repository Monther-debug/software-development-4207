<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Resources\RatingResource;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        // Only show ratings created by the authenticated user
        $ratings = Rating::where('userID', auth()->id())->latest()->get();
        return RatingResource::collection($ratings);
    }

    public function store(StoreRatingRequest $request)
    {
        // Automatically set the authenticated user's ID
        $data = $request->validated();
        $data['userID'] = auth()->id();
        
        $rating = Rating::create($data);
        return (new RatingResource($rating))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Rating $rating)
    {
        // Ensure user can only view their own rating
        if ($rating->userID !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return new RatingResource($rating);
    }

    public function update(StoreRatingRequest $request, Rating $rating)
    {
        // Ensure user can only update their own rating
        if ($rating->userID !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $rating->update($request->validated());
        return new RatingResource($rating);
    }

    public function destroy(Rating $rating)
    {
        // Ensure user can only delete their own rating
        if ($rating->userID !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $rating->delete();
        return response()->json(null, 204);
    }

    // Compute average rating for a given entity
    public function average(Request $request)
    {
        $request->validate([
            'rateable_type' => 'required|string',
            'rateable_id' => 'required|integer',
        ]);

        $avg = Rating::where('rateable_type', $request->rateable_type)
            ->where('rateable_id', $request->rateable_id)
            ->avg('score');

        return response()->json([
            'rateable_type' => $request->rateable_type,
            'rateable_id' => (int) $request->rateable_id,
            'average' => $avg ? round((float) $avg, 2) : null,
        ]);
    }
}
