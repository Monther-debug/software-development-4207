<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Rating\StoreRatingRequest;
use App\Http\Requests\User\Rating\UpdateRatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Rating;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::where('userID', auth('api')->id())->get();
        return RatingResource::collection($ratings);
    }

    public function store(StoreRatingRequest $request)
    {
        $data = $request->validated();
        $data['userID'] = auth('api')->id();
        $rating = Rating::create($data);
        return new RatingResource($rating);
    }

    public function show(Rating $rating)
    {
        if (auth('api')->id() !== $rating->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return new RatingResource($rating);
    }

    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        if (auth('api')->id() !== $rating->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $rating->update($request->validated());
        return new RatingResource($rating);
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
