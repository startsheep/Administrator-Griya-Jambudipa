<?php

use App\Http\Controllers\API\PositionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('position')->group(function () {
        Route::get('/', [PositionController::class, 'index'])->name('api.position.index');
        Route::post('/', [PositionController::class, 'store'])->name('api.position.store');
        Route::get('/{id}', [PositionController::class, 'show'])->name('api.position.show');
        Route::put('/{id}', [PositionController::class, 'update'])->name('api.position.update');
        Route::delete('/{id}', [PositionController::class, 'delete'])->name('api.position.delete');
    });
});
