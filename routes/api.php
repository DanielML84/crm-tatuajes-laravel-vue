<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ClienteController;
use App\Http\Controllers\Api\V1\ArtistaController;
use App\Http\Controllers\Api\V1\CitaController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AgendaController;
use App\Http\Controllers\Api\V1\HitoController;
use App\Http\Controllers\Api\V1\EstadoHitoController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (no requieren token)
|--------------------------------------------------------------------------
*/
Route::post('v1/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Rutas Protegidas (requieren autenticación con Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    // Rutas de Usuario y Sesión
    Route::get('v1/user', [AuthController::class, 'user']);
    Route::post('v1/logout', [AuthController::class, 'logout']);

    // === RUTAS ESPECÍFICAS (GET) ===
    // Estas deben ir SIEMPRE ANTES de los apiResource para evitar conflictos.
    Route::get('v1/clientes/list', [ClienteController::class, 'list']);
    Route::get('v1/artistas/list', [ArtistaController::class, 'list']);
    Route::get('v1/agenda', [AgendaController::class, 'index']);
    Route::get('v1/estados-hitos', [EstadoHitoController::class, 'index']);

    // === RUTAS DE RECURSO (apiResource) ===
    // Estas son más genéricas y van al final del grupo.
    Route::apiResource('v1/clientes', ClienteController::class);
    Route::apiResource('v1/artistas', ArtistaController::class);
    Route::apiResource('v1/citas', CitaController::class);
    Route::apiResource('v1/citas.hitos', HitoController::class)->shallow();

});