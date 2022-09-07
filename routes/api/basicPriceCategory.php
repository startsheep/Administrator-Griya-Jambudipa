<?php

use App\Http\Controllers\API\BasicPriceCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('basic-price-category')->group(function () {
        Route::get('/', [BasicPriceCategoryController::class, 'index'])->name('api.basic.price.category.index');
        Route::post('/', [BasicPriceCategoryController::class, 'store'])->name('api.basic.price.category.store');
        Route::get('/{id}', [BasicPriceCategoryController::class, 'show'])->name('api.basic.price.category.show');
        Route::put('/{id}', [BasicPriceCategoryController::class, 'update'])->name('api.basic.price.category.update');
        Route::delete('/{id}', [BasicPriceCategoryController::class, 'delete'])->name('api.basic.price.category.delete');
    });
});
