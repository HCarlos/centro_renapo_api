<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CURPAPIController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    Route::post('/auth.login.curp', [AuthController::class, 'login_api'])->name('auth.login.curp');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/consulta.datos', [CURPAPIController::class, 'consultaPorDatos'])->name('consulta.datos');
        Route::post('/consulta.curp', [CURPAPIController::class, 'consultaPorCurp'])->name('consulta.curp');
    });

});
