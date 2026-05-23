<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\TemporadaController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\BloqueController;
use App\Http\Controllers\TipoEspacioController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\RespaldoController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\ReunionController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\PorcentajeController;
use App\Http\Controllers\TipoRespaldoController;
use App\Http\Controllers\ModalidadController;
use App\Http\Controllers\TipoCrmController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'funLogin']);   
    Route::post('/register', [AuthController::class, 'funRegister']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'funProfile']);   
        Route::post('/logout', [AuthController::class, 'funLogout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    // Clientes
    Route::get('/cliente/instituciones', [ClienteController::class, 'clienteInstituciones']);
    Route::get('/cliente/contactos', [ClienteController::class, 'clienteContactos']);
    Route::get('/cliente/instituciones/{id}/contactos', [ClienteController::class, 'clienteInstitucionesContactos']);
    Route::apiResource('cliente', ClienteController::class);  

    // Eventos y Espacios
    Route::apiResource('eventos', EventoController::class);
    Route::apiResource('temporadas', TemporadaController::class);
    Route::apiResource('espacios', EspacioController::class);
    Route::apiResource('bloques', BloqueController::class);
    Route::apiResource('tipo-espacios', TipoEspacioController::class);

    // Cotizaciones
    Route::post('cotizaciones/preview', [CotizacionController::class, 'preview']);
    Route::apiResource('cotizaciones', CotizacionController::class);

    Route::prefix('cotizaciones/{id}')->group(function () {
        Route::get('imprimir', [CotizacionController::class, 'imprimir']);

        // Pagos y Respaldos (Sub-recursos)
        Route::post('registrar-pago', [PagoController::class, 'registrarPago']);
        Route::get('respaldos', [RespaldoController::class, 'index']);
        Route::post('subir-respaldo', [RespaldoController::class, 'store']);

        // CRM y Seguimiento (Sub-recursos)
        Route::get('crms', [CrmController::class, 'index']);
        Route::post('crms', [CrmController::class, 'store']);

        // Reuniones (Sub-recursos)
        Route::get('reuniones', [ReunionController::class, 'index']);
        Route::post('reuniones', [ReunionController::class, 'store']);
    });

    // Reuniones — Rutas independientes
    Route::post('reuniones/{id}/acta', [ReunionController::class, 'subirActa']);

    // Módulo Administrativo / Pagos
    Route::get('administrativo/pagos-pendientes', [PagoController::class, 'pagosPendientes']);
    Route::put('pagos/{id}/verificar', [PagoController::class, 'verificarPago']);

    // Tarifas y Servicios
    Route::apiResource('servicios', ServicioController::class);
    Route::get('tarifas/espacio/{espacioId}/temporada/{temporadaId}/evento/{eventoId}', [TarifaController::class, 'getByFiltro']);
    Route::get('tarifas/espacio/{espacioId}/temporada/{temporadaId}', [TarifaController::class, 'getByEspacioAndTemporada']);
    Route::get('tarifas/espacio/{espacioId}/baja', [TarifaController::class, 'getBajasByEspacio']);
    Route::get('tarifas/espacio/{espacioId}/alta', [TarifaController::class, 'getAltasByEspacio']);
    Route::get('tarifas/espacio/{espacioId}', [TarifaController::class, 'getByEspacio']);
    Route::apiResource('tarifas', TarifaController::class);

    // Lookups Maestros
    Route::get('bancos', [BancoController::class, 'index']);
    Route::get('porcentajes', [PorcentajeController::class, 'index']);
    Route::get('tipo-respaldos', [TipoRespaldoController::class, 'index']);
    Route::get('modalidades', [ModalidadController::class, 'index']);
    Route::get('tipo-crms', [TipoCrmController::class, 'index']);
});
