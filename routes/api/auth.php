<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class)->name('api.auth.login');

    Route::post('reset-password', ResetPasswordController::class)->name('api.auth.reset.password');

    Route::post('new-password', NewPasswordController::class)->name('api.auth.new.password');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', LogoutController::class)->name('api.auth.logout');

        Route::post('check', AuthenticatedController::class)->name('api.auth.check');
    });
});
