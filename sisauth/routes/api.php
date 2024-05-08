<?php

use Illuminate\Support\Facades\Route; // Correção da importação de Route
use App\Http\Controllers\AuthController; // Adicionando o uso do namespace completo
use App\Http\Controllers\UserController; // Adicionando o uso do namespace completo

// Definindo rotas usando a sintaxe de array para o Laravel 8+
$router->group(['middleware' => 'cors'], function () use ($router) {
    Route::post('/api/login', [AuthController::class, 'login']);
    Route::middleware(['jwt.auth'])->group(function () {
        Route::get('/api/logout', [AuthController::class, 'logout']);
        Route::post('/api/register', [UserController::class, 'register']);
        Route::get('/api/users', [UserController::class, 'index']);
    });
});
