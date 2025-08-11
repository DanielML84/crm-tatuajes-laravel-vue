<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ClienteController;
use App\Http\Controllers\Api\V1\ArtistaController;
use App\Http\Controllers\Api\V1\CitaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Resources para nuestro CRM
Route::apiResource('v1/clientes', ClienteController::class);
Route::apiResource('v1/artistas', ArtistaController::class);
Route::apiResource('v1/citas', CitaController::class);