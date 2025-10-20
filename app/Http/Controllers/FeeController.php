<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with(['school', 'grade'])->latest()->get();
        return response()->json($fees);
    }

    public function store(StoreFeeRequest $request)
    {
        $data = $request->validated();

        // Enforce uniqueness of code per school at app level (DB constraint also exists)
        if (Fee::where('school_id', $data['school_id'])->where('code', $data['code'])->exists()) {
            return response()->json([
                'message' => 'The code has already been taken for this school.'
            ], 422);
        }

        $fee = Fee::create($data);
        return response()->json($fee->load(['school', 'grade']), 201);
    }

    public function show(Fee $fee)
    {
        return response()->json($fee->load(['school', 'grade']));
    }

    public function update(UpdateFeeRequest $request, Fee $fee)
    {
        $data = $request->validated();

        if (isset($data['code']) || isset($data['school_id'])) {
            $schoolId = $data['school_id'] ?? $fee->school_id;
            $code = $data['code'] ?? $fee->code;
            $exists = Fee::where('school_id', $schoolId)
                ->where('code', $code)
                ->where('id', '!=', $fee->id)
                ->exists();
            if ($exists) {
                return response()->json([
                    'message' => 'The code has already been taken for this school.'
                ], 422);
            }
        }

        $fee->update($data);
        return response()->json($fee->load(['school', 'grade']));
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();
        return response()->json(null, 204);
    }
}
