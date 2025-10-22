<?php

use Illuminate\Support\Facades\Route;

/*
// Puedes borrar esta ruta o comentarla como he hecho yo
Route::get('/', function () {
    return view('welcome');
});
*/

// Dejamos solo la ruta que nos interesa
Route::get('/', function () {
    return view('app');
});