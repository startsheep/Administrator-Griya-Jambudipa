<?php

use App\Http\Controllers\API\PaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('api.payment.index');
        Route::post('/', [PaymentController::class, 'store'])->name('api.payment.store');
        Route::get('/{id}', [PaymentController::class, 'show'])->name('api.payment.show');
    });
});
