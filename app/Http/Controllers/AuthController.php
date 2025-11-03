<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'guard' => 'required|string|in:api,manager,admin,teacher',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');
        $guard = $request->input('guard', 'api');

        if (! $token = auth($guard)->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, $guard);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'guard' => 'required|string|in:api,manager,admin,teacher',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $guard = $request->input('guard', 'api');
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = auth($guard)->login($user);

        return $this->respondWithToken($token, $guard);
    }

    public function me(Request $request)
    {
        $guard = $request->input('guard', 'api');
        return response()->json(auth($guard)->user());
    }

    public function logout(Request $request)
    {
        $guard = $request->input('guard', 'api');
        auth($guard)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(Request $request)
    {
        $guard = $request->input('guard', 'api');
        return $this->respondWithToken(auth($guard)->refresh(), $guard);
    }

    protected function respondWithToken($token, $guard = 'api')
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($guard)->factory()->getTTL() * 60,
            'guard' => $guard
        ]);
    }
}
