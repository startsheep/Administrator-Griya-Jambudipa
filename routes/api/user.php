<?php

use App\Http\Controllers\API\AccountController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('api.user.index');
        Route::post('/', [AccountController::class, 'store'])->name('api.user.store');
        Route::get('/show-email/{email}', [AccountController::class, 'showByEmail'])->name('api.user.show.email');
        Route::get('/{id}', [AccountController::class, 'show'])->name('api.user.show');
        Route::put('/{id}', [AccountController::class, 'update'])->name('api.user.update');
        Route::put('/active/{id}', [AccountController::class, 'changeStatus'])->name('api.user.change.status');
        Route::put('/change-password/{id}', [AccountController::class, 'changePassword'])->name('api.user.change.password');
        Route::delete('/{id}', [AccountController::class, 'delete'])->name('api.user.delete');
    });
});
