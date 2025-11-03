<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AuthController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
});



Route::apiResource('schools', SchoolController::class);
Route::apiResource('managers', ManagerController::class);
Route::apiResource('admins', AdminController::class);
Route::apiResource('grades', GradeController::class);
Route::apiResource('teachers', TeacherController::class);
Route::apiResource('fees', FeeController::class);
Route::apiResource('comments', CommentController::class);
Route::apiResource('ratings', RatingController::class);
Route::post('ratings/average', [RatingController::class, 'average']);

// Nested school-teacher assignments
use App\Http\Controllers\SchoolTeacherController;
Route::get('schools/{school}/teachers', [SchoolTeacherController::class, 'index']);
Route::post('schools/{school}/teachers', [SchoolTeacherController::class, 'store']);
Route::put('schools/{school}/teachers/{teacher}', [SchoolTeacherController::class, 'update']);
Route::delete('schools/{school}/teachers/{teacher}', [SchoolTeacherController::class, 'destroy']);
