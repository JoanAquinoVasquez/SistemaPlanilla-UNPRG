<?php


use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('users', [AuthController::class, 'index']);
    Route::get('users/{id}', [AuthController::class, 'show']);
});


Route::middleware(['auth:api'])->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    // Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('users', [AuthController::class, 'index']);
    Route::get('users/{id}', [AuthController::class, 'show']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('/google-login', [AuthController::class, 'googleLogin']);
