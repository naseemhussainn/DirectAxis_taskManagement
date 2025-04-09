<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::apiResource('tasks', TaskController::class)->only(['index', 'store']);
    
    Route::put('/tasks/{task}/assign', [TaskController::class, 'assign']);
    Route::put('/tasks/{task}/complete', [TaskController::class, 'complete']);
});