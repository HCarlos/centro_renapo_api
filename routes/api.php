<?php

use App\Http\Controllers\ConsultaController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
//    Route::post('/consulta-datos', [ConsultaController::class, 'consultaPorDatos'])->name('api.consulta-datos');
//    Route::post('/consulta-curp', [ConsultaController::class, 'consultaPorCurp'])->name('api.consulta-curp');
});
