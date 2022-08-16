<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('url.auth.login.index');
    Route::post('login', [LoginController::class, 'process'])->name('url.auth.login.process');

    // Route::post('register', RegisterController::class)->name('api.auth.register');

    // Route::middleware(['auth:sanctum'])->group(function () {
    //     Route::post('logout', LogoutController::class)->name('api.auth.logout');

    //     Route::post('check', AuthenticatedController::class)->name('api.auth.check');
    // });
});
