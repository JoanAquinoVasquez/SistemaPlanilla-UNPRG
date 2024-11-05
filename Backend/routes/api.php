<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BancoController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:api'])->group(function () {
    // Route::post('register', [AuthController::class, 'register']);
    // Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);

    Route::apiResource('bancos', BancoController::class);

});

Route::post('/google-login', [AuthController::class, 'googleLogin']);
