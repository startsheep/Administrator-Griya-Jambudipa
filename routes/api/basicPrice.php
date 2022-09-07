<?php

use App\Http\Controllers\API\BasicPriceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('basic-price')->group(function () {
        Route::get('/', [BasicPriceController::class, 'index'])->name('api.building.price.index');
        Route::post('/', [BasicPriceController::class, 'store'])->name('api.building.price.store');
        Route::get('/{id}', [BasicPriceController::class, 'show'])->name('api.building.price.show');
        Route::put('/{id}', [BasicPriceController::class, 'update'])->name('api.building.price.update');
        Route::delete('/{id}', [BasicPriceController::class, 'delete'])->name('api.building.price.delete');
    });
});
