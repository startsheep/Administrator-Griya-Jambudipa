<?php

use App\Http\Controllers\API\BuildingPriceCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('building-category')->group(function () {
        Route::get('/', [BuildingPriceCategoryController::class, 'index'])->name('api.building.category.index');
        Route::post('/', [BuildingPriceCategoryController::class, 'store'])->name('api.building.category.store');
        Route::get('/{id}', [BuildingPriceCategoryController::class, 'show'])->name('api.building.category.show');
        Route::put('/{id}', [BuildingPriceCategoryController::class, 'update'])->name('api.building.category.update');
        Route::delete('/{id}', [BuildingPriceCategoryController::class, 'delete'])->name('api.building.category.delete');
    });
});
