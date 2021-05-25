<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\ApiTaskController;

Route::post('auth/register', [ApiTokenController::class , 'store']);
Route::post('auth/login', [ApiTokenController::class , 'login']);
Route::middleware('auth:sanctum')->post('auth/me', [ApiTokenController::class , 'me']);
Route::middleware('auth:sanctum')->post('auth/logout', [ApiTokenController::class , 'me']);
Route::middleware('auth:sanctum')->post('tasksuser', [ApiTaskController::class , 'gettask']);
Route::middleware('auth:sanctum')->apiResource('tasks', ApiTaskController::class );
