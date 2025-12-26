<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\UserRoleController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::middleware(['auth:sanctum', 'role:Administrador'])->prefix('admin')->group(function () {
    
    Route::get('/users', [UserRoleController::class, 'index']);
    Route::post('/users', [UserRoleController::class, 'store']);
    Route::post('/users/{id}/role', [UserRoleController::class, 'assignRole']);

    /*
    Route::post('/users/{id}/permissions', [UserRoleController::class, 'assignPermissions']);
    Route::delete('/users/{id}/reset', [UserRoleController::class, 'resetAccess']);
    Route::get('/catalog', [UserRoleController::class, 'catalog']);*/

});