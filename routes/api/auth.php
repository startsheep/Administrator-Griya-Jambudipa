<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class)->name('api.auth.login');

    // Route::post('register', RegisterController::class)->name('api.auth.register');

    // Route::middleware(['auth:sanctum'])->group(function () {
    //     Route::post('logout', LogoutController::class)->name('api.auth.logout');

    //     Route::post('check', AuthenticatedController::class)->name('api.auth.check');
    // });
});
