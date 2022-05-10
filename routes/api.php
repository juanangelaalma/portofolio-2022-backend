<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::get('projects', [ProjectsController::class, 'index']);

Route::post('login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('profile', function() {
        return auth()->user();
    });

    Route::post('projects', [ProjectsController::class, 'store']);

    Route::put('projects/{id}', [ProjectsController::class, 'update']);
    
    Route::delete('projects/{id}', [ProjectsController::class, 'destroy']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('upload', [FileController::class, 'upload']);
});