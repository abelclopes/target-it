<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AddressController;

Route::group(['middleware' => 'api'], function () {
    Route::post('/api/auth/login', [AuthController::class, 'login']);

    Route::middleware(['jwt.auth'])->group(function () {
        
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        Route::get('/addresses/{id}/details', 'AddressController@index');
        Route::get('/addresses/{uid}/user-details', 'AddressController@getAddresUserId');
        Route::post('/addresses/{uid}/new', 'AddressController@store');
        Route::put('/addresses/{id}/update', 'AddressController@update');
        Route::delete('/addresses/{id}/delete', 'AddressController@destroy');
    });
});
Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'userProfile']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassWord']);
});
