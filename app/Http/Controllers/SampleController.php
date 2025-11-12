<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;

class SampleController extends Controller
{
  public function index()
    {
        $samples = Sample::all();
        return response()->json($samples);
    }

    public function add(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        $sample = Sample::create($request->only('text'));

        return response()->json($sample, 201);
    }
}