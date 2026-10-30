<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [App\Http\Controllers\Api\AuthController::class, 'me']);
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::middleware('role:ADMIN,MANAGER')->group(function () {
        Route::apiResource('branches', App\Http\Controllers\Api\BranchController::class);
    });

    Route::middleware('role:ADMIN,MANAGER,CASHIER')->group(function () {
        Route::apiResource('menu-items', App\Http\Controllers\Api\MenuItemController::class);
        Route::get('/orders', [App\Http\Controllers\Api\OrderController::class, 'index']);
        Route::get('/orders/{id}', [App\Http\Controllers\Api\OrderController::class, 'show']);
        Route::post('/orders', [App\Http\Controllers\Api\OrderController::class, 'store']);
        Route::patch('/orders/{id}/status', [App\Http\Controllers\Api\OrderController::class, 'updateStatus']);
    });

    Route::middleware('permission:reports.view')->group(function () {
        Route::get('/dashboard/summary', [App\Http\Controllers\Api\DashboardController::class, 'summary']);
    });
});
