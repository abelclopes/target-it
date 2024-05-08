<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'cors'], function () {
    Route::post('/api/login', [AuthController::class, 'login']);

    Route::middleware(['jwt.auth'])->group(function () {
        Route::get('/api/logout', [AuthController::class, 'logout']);
        
        Route::get('/api/users', [UserController::class, 'index']);
        Route::get('/api/users/{id}', [UserController::class, 'show']); // Rota para mostrar detalhes de um usuário pelo ID
        Route::post('/api/users', [UserController::class, 'store']); // Rota para criar um novo usuário
        Route::put('/api/users/{id}', [UserController::class, 'update']); // Rota para atualizar um usuário pelo ID
        Route::delete('/api/users/{id}', [UserController::class, 'destroy']); // Rota para excluir um usuário pelo ID

        Route::get('/api/addresses/{id}/details', 'AddressController@index');
        Route::get('/api/addresses/{uid}/user-details', 'AddressController@getAddresUserId');
        Route::post('/api/addresses/{uid}/new', 'AddressController@store');
        Route::put('/api/addresses/{id}/update', 'AddressController@update');
        Route::delete('/api/addresses/{id}/delete', 'AddressController@destroy');
    });
});
