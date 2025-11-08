<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([ 
            "phone_number" => "required|string",
            "password" => "required|string"
        ]);

        if (!$token = auth('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin')->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        auth('admin')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
