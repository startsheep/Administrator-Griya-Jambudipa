<?php

use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('api.payment.index');
        Route::post('/', [PaymentController::class, 'store'])->name('api.payment.store');
        Route::get('/{id}', [PaymentController::class, 'show'])->name('api.payment.show');
    });

    Route::prefix('transaction')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('api.transaction.index');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('api.transaction.show');
    });
});
