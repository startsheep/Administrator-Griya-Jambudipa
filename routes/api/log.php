<?php

use App\Http\Controllers\API\LogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('log')->group(function () {
        Route::get('/', [LogController::class, 'index'])->name('api.log.index');
        Route::get('/{id}', [LogController::class, 'show'])->name('api.log.show');
    });
});
