<?php

use App\Http\Controllers\API\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('api.customer.index');
        Route::post('/', [CustomerController::class, 'store'])->name('api.customer.store');
        Route::get('/{id}', [CustomerController::class, 'show'])->name('api.customer.show');
        Route::put('/{id}', [CustomerController::class, 'update'])->name('api.customer.update');
        Route::delete('/{id}', [CustomerController::class, 'delete'])->name('api.customer.delete');
    });
});
