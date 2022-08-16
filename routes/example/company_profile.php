<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('url.auth.login.index');
    Route::post('login', [LoginController::class, 'process'])->name('url.auth.login.process');
});
