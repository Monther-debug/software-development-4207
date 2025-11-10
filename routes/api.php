<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Manager\GradeController;
use App\Http\Controllers\Manager\FeeController;
use App\Http\Controllers\Manager\SchoolSuccessRateController as ManagerSchoolSuccessRateController;
use App\Http\Controllers\User\RatingController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\Manager\SchoolTeacherController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Manager\AuthController as ManagerAuthController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\Admin\SchoolSuccessRateController as AdminSchoolSuccessRateController;

// Authentication endpoints
Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::post('manager/login', [ManagerAuthController::class, 'login']);
Route::post('user/login', [UserAuthController::class, 'login']);
Route::post('user/register', [UserAuthController::class, 'register']);

// Admin routes - protected by admin guard
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::apiResource('managers', ManagerController::class);
    Route::apiResource('schools', SchoolController::class);
    Route::apiResource('teachers', TeacherController::class);
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::get('school-success-rate', [AdminSchoolSuccessRateController::class, 'index']);
    Route::get('school-success-rate/{schoolId}', [AdminSchoolSuccessRateController::class, 'show']);
});

// Manager routes - protected by manager guard
Route::middleware('auth:manager')->prefix('manager')->group(function () {
    Route::apiResource('grades', GradeController::class);
    Route::apiResource('fees', FeeController::class);
    
    Route::prefix('schools')->group(function () {
        Route::get('teachers', [SchoolTeacherController::class, 'index']);
        Route::post('teachers', [SchoolTeacherController::class, 'store']);
        Route::put('teachers/{teacher}', [SchoolTeacherController::class, 'update']);
        Route::delete('teachers/{teacher}', [SchoolTeacherController::class, 'destroy']);
    });
    
    // Success ratings
    Route::apiResource('success-ratings', ManagerSchoolSuccessRateController::class);
    Route::post('logout', [ManagerAuthController::class, 'logout']);
});

// User routes - protected by api guard
Route::middleware('auth:api')->prefix('user')->group(function () {
    Route::apiResource('ratings', RatingController::class);
    Route::apiResource('comments', CommentController::class);
    Route::post('logout', [UserAuthController::class, 'logout']);
});
