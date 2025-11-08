<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::where('schoolID', auth('manager')->user()->schoolID)->get();
        return response()->json($fees);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'gradeID' => 'required|exists:grades,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $validatedData['schoolID'] = auth('manager')->user()->schoolID;
        $fee = Fee::create($validatedData);
        return response()->json($fee, 201);
    }

    public function show(Fee $fee)
    {
        if ($fee->schoolID != auth('manager')->user()->schoolID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($fee);
    }

    public function update(Request $request, Fee $fee)
    {
        if ($fee->schoolID != auth('manager')->user()->schoolID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'gradeID' => 'sometimes|exists:grades,id',
            'amount' => 'sometimes|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $fee->update($validatedData);
        return response()->json($fee);
    }

    public function destroy(Fee $fee)
    {
        if ($fee->schoolID != auth('manager')->user()->schoolID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $fee->delete();
        return response()->json(null, 204);
    }
}
