<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Welcome');
})->name('welcome');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::post('/consulta-datos', [ConsultaController::class, 'consultaPorDatos'])->name('consulta-datos');
    Route::post('/consulta-curp', [ConsultaController::class, 'consultaPorCurp'])->name('consulta-curp');

});

//require __DIR__.'/auth.php';
