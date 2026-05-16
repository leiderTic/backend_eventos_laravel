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

    
    // Tarifas
    Route::get('tarifas/espacio/{espacioId}/temporada/{temporadaId}/evento/{eventoId}', [\App\Http\Controllers\TarifaController::class, 'getByFiltro']);
    Route::get('tarifas/espacio/{espacioId}/temporada/{temporadaId}', [\App\Http\Controllers\TarifaController::class, 'getByEspacioAndTemporada']);
    Route::get('tarifas/espacio/{espacioId}/baja', [\App\Http\Controllers\TarifaController::class, 'getBajasByEspacio']);
    Route::get('tarifas/espacio/{espacioId}/alta', [\App\Http\Controllers\TarifaController::class, 'getAltasByEspacio']);
    Route::get('tarifas/espacio/{espacioId}', [\App\Http\Controllers\TarifaController::class, 'getByEspacio']);
    Route::apiResource('tarifas', \App\Http\Controllers\TarifaController::class);

    // Cotizaciones y Servicios
    Route::apiResource('servicios', \App\Http\Controllers\ServicioController::class);
    Route::post('cotizaciones/preview', [\App\Http\Controllers\CotizacionController::class, 'preview']);
    Route::get('cotizaciones/{id}/imprimir', [\App\Http\Controllers\CotizacionController::class, 'imprimir']);
    Route::post('cotizaciones/{id}/registrar-pago', [\App\Http\Controllers\PagoController::class, 'registrarPago']);
    Route::get('cotizaciones/{id}/respaldos', [\App\Http\Controllers\RespaldoController::class, 'index']);
    Route::post('cotizaciones/{id}/subir-respaldo', [\App\Http\Controllers\RespaldoController::class, 'store']);
    Route::apiResource('cotizaciones', \App\Http\Controllers\CotizacionController::class);

    // Módulo Administrativo / Pagos
    Route::get('administrativo/pagos-pendientes', [\App\Http\Controllers\PagoController::class, 'pagosPendientes']);
    Route::put('pagos/{id}/verificar', [\App\Http\Controllers\PagoController::class, 'verificarPago']);

    // Lookups Maestros
    Route::get('bancos', [\App\Http\Controllers\BancoController::class, 'index']);
    Route::get('porcentajes', [\App\Http\Controllers\PorcentajeController::class, 'index']);
    Route::get('tipo-respaldos', [\App\Http\Controllers\TipoRespaldoController::class, 'index']);
});

