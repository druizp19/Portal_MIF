<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SistemaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/auth/microsoft', [AuthController::class, 'redirectToMicrosoft'])->name('auth.microsoft');
Route::get('/auth/microsoft/callback', [AuthController::class, 'handleMicrosoftCallback'])->name('auth.microsoft.callback');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout-sso', [AuthController::class, 'logoutSSO'])->name('logout.sso');


Route::middleware('check.usuario')->group(function () {
    Route::get('/sistemas', [SistemaController::class, 'index'])->name('sistemas.index');
    Route::get('/sistemas/{sistema}', [SistemaController::class, 'redirectToSistema'])->name('sistemas.redirect');
});
