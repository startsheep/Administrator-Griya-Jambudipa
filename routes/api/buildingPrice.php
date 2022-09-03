<?php

use App\Http\Controllers\API\BuildingPriceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('building-price')->group(function () {
        Route::get('/', [BuildingPriceController::class, 'index'])->name('api.building.price.index');
        Route::post('/', [BuildingPriceController::class, 'store'])->name('api.building.price.store');
        Route::get('/{id}', [BuildingPriceController::class, 'show'])->name('api.building.price.show');
        Route::put('/{id}', [BuildingPriceController::class, 'update'])->name('api.building.price.update');
        Route::delete('/{id}', [BuildingPriceController::class, 'delete'])->name('api.building.price.delete');
    });
});
