<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\FormulaController;
use App\Http\Controllers\FormulaParametroController;
use App\Http\Controllers\ParametroController;
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
    //Documento
    Route::apiResource('documentos', DocumentoController::class);
    //Formula
    Route::apiResource('formulas', FormulaController::class);
    //Parametro
    Route::apiResource('parametros', ParametroController::class);
    //FormulaParametro
    Route::apiResource('formula-parametro', FormulaParametroController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/google-login', [AuthController::class, 'googleLogin']);
Route::get('/check-auth', [AuthController::class, 'checkAuth']); // Nueva ruta para verificar autenticación

