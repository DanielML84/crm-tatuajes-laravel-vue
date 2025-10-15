<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ClienteController;
use App\Http\Controllers\Api\V1\ArtistaController;
use App\Http\Controllers\Api\V1\CitaController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AgendaController;

// Rutas Públicas (Login)
Route::post('v1/login', [AuthController::class, 'login']);

// Rutas Protegidas (necesitan token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('v1/user', [AuthController::class, 'user']);
    Route::post('v1/logout', [AuthController::class, 'logout']);

    // ====================================================================
    // === INICIO DE LA CORRECCIÓN: Rutas específicas PRIMERO ===
    // ====================================================================
    Route::get('v1/clientes/list', [ClienteController::class, 'list']);
    Route::get('v1/artistas/list', [ArtistaController::class, 'list']);
    Route::get('v1/agenda', [AgendaController::class, 'index']);
    // ====================================================================
    // === FIN DE LA CORRECCIÓN ===========================================
    // ====================================================================

    // API Resources (con comodines) DESPUÉS
    Route::apiResource('v1/clientes', ClienteController::class);
    Route::apiResource('v1/artistas', ArtistaController::class);
    Route::apiResource('v1/citas', CitaController::class);
});