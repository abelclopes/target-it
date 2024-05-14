<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\RoleController;

Route::group(['middleware' => ['api', 'jwt.auth']], function () {
    
    Route::middleware(['role:Admin,Editor,Viewer'])->group(function () {        
        Route::get('/auth/profile', [AuthController::class, 'userProfile']);
        Route::post('/auth/change-password', [AuthController::class, 'changePassWord']);
    });
    
    Route::middleware(['role:Admin,Editor'])->group(function () {
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
    
    Route::middleware(['role:Admin,Editor'])->group(function () {
        Route::post('/users/{user}/assign-role', [RoleController::class, 'assignRole']);
        Route::post('/users/{user}/revoke-role', [RoleController::class, 'revokeRole']);
        Route::get('/roles', [RoleController::class, 'getAllRoles']);
        Route::get('/users/{user}/roles', [RoleController::class, 'getUserRoles']);
    });
});

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
