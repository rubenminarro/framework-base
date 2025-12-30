<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\UserRoleController;
use App\Http\Controllers\Api\Admin\PermissionController;
use App\Http\Controllers\Api\Admin\RoleController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::middleware(['auth:sanctum', 'role:Administrador'])->prefix('admin')->group(function () {
    
    Route::get('/users', [UserRoleController::class, 'index']);
    Route::post('/users', [UserRoleController::class, 'store']);
    Route::get('/users/{user}', [UserRoleController::class, 'show']);
    Route::put('/users/{user}', [UserRoleController::class, 'update']);
    Route::post('/users/{user}/activate', [UserRoleController::class, 'activate']);
    Route::post('/users/{user}/deactivate', [UserRoleController::class, 'deactivate']);

    Route::get('permissions', [PermissionController::class, 'index']);
    Route::post('permissions', [PermissionController::class, 'store']);
    Route::get('permissions/{permission}', [PermissionController::class, 'show']);
    Route::put('permissions/{permission}', [PermissionController::class, 'update']);
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy']);

    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::get('/roles/{role}', [RoleController::class, 'show']);
    Route::put('/roles/{role}', [RoleController::class, 'update']);
    Route::delete('/roles/{role}', [RoleController::class, 'destroy']);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'syncPermissions']);
    

});