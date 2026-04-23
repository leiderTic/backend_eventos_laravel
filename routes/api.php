<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CotizacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('/v1/auth')->group(function () {
    
    Route::post('/login', [AuthController::class, 'funLogin']);   
    Route::post('/register', [AuthController::class, 'funRegister']);
    
    Route::middleware('auth:sanctum')->group(function () {
        // Define your protected routes here
        Route::get('/profile', [AuthController::class, 'funProfile']);   
        Route::post('/logout', [AuthController::class, 'funLogout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});
