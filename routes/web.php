<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;

Route::get('/', function () {
    return view('welcome');
});




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('tasks', TaskController::class)->only(['index', 'store']);
    Route::put('/tasks/{task}/assign', [TaskController::class, 'assign']);
    Route::put('/tasks/{task}/complete', [TaskController::class, 'complete']);
});