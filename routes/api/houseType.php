<?php

use App\Http\Controllers\API\HouseTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('house-type')->group(function () {
        Route::get('/', [HouseTypeController::class, 'index'])->name('api.house.type.index');
        Route::post('/', [HouseTypeController::class, 'store'])->name('api.house.type.store');
        Route::get('/{id}', [HouseTypeController::class, 'show'])->name('api.house.type.show');
        Route::put('/{id}', [HouseTypeController::class, 'update'])->name('api.house.type.update');
        Route::delete('/{id}', [HouseTypeController::class, 'delete'])->name('api.house.type.delete');
    });
});
