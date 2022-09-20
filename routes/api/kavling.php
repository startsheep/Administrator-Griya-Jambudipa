<?php

use App\Http\Controllers\API\KavlingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('kavling')->group(function () {
        Route::get('/', [KavlingController::class, 'index'])->name('api.kavling.index');
        Route::post('/', [KavlingController::class, 'store'])->name('api.kavling.store');
        Route::get('/check/{customer_id}', [KavlingController::class, 'paymentCheck'])->name('api.kavling.check');
        Route::get('/{id}', [KavlingController::class, 'show'])->name('api.kavling.show');
        Route::put('/{id}', [KavlingController::class, 'update'])->name('api.kavling.update');
        Route::delete('/{id}', [KavlingController::class, 'delete'])->name('api.kavling.delete');
    });
});
