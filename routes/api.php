<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cliente/instituciones', [ClienteController::class, 'clienteInstituciones']);
    Route::get('/cliente/contactos', [ClienteController::class, 'clienteContactos']);
    Route::get('/cliente/instituciones/{id}/contactos', [ClienteController::class, 'clienteInstitucionesContactos']);
    Route::apiResource('cliente', ClienteController::class);  

    // Eventos
    Route::apiResource('eventos', \App\Http\Controllers\EventoController::class);

    // Temporadas
    Route::apiResource('temporadas', \App\Http\Controllers\TemporadaController::class);

    // Espacios
    Route::apiResource('espacios', \App\Http\Controllers\EspacioController::class);

    // Tipos y Extras
    Route::apiResource('bloques', \App\Http\Controllers\BloqueController::class);
    Route::apiResource('tipo-espacios', \App\Http\Controllers\TipoEspacioController::class);
    Route::apiResource('tipo-tarifas', \App\Http\Controllers\TipoTarifaController::class);
    
    // Tarifas
    Route::get('tarifas/espacio/{espacioId}', [\App\Http\Controllers\TarifaController::class, 'getByEspacio']);
    Route::apiResource('tarifas', \App\Http\Controllers\TarifaController::class);
        
});

