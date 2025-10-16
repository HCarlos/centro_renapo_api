<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CURPAPIController;
use Illuminate\Support\Facades\Route;

Route::post('/auth.login.curp', [AuthController::class, 'login_api'])->name('auth.login.curp');

//Route::middleware('auth:sanctum')->group(function () {
    Route::post('/api.consulta-datos', [CURPAPIController::class, 'consultaPorDatos'])->name('api.consulta-datos');
    Route::post('/api.consulta-curp', [CURPAPIController::class, 'consultaPorCurp'])->name('api.consulta-curp');

//});
