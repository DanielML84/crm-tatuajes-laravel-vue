<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
    // 1. Importa la clase de la excepción de autenticación al principio de la función
    $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
        // 2. Si la petición es una API que espera JSON
        if ($request->expectsJson()) {
            // 3. Devuelve una respuesta JSON con error 401
            return response()->json(['message' => 'No autenticado.'], 401);
        }
    });
})->create();
