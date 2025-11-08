<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuccessRating;
use Illuminate\Http\Request;

class SchoolSuccessRateController extends Controller
{
    public function index()
    {
        $successRatings = SuccessRating::all();
        return response()->json($successRatings);
    }

    public function show($schoolId)
    {
        $successRatings = SuccessRating::where('schoolID', $schoolId)->get();
        return response()->json($successRatings);
    }
}
