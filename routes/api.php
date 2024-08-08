<?php
use Illuminate\Support\Facades\Route;


Route::prefix('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/user', [UserController::class, 'show']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
