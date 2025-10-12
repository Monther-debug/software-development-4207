<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group and "api" prefix.
|
*/

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::apiResource('schools', SchoolController::class);
Route::apiResource('managers', ManagerController::class);
Route::apiResource('admins', AdminController::class);
