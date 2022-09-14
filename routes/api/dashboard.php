<?php

use App\Http\Controllers\API\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/count-customer', [DashboardController::class, 'countCustomer'])->name('api.dashboard.count.customer');
        Route::get('/count-transaction', [DashboardController::class, 'countTransaction'])->name('api.dashboard.count.transaction');
        Route::get('/kavling', [DashboardController::class, 'kavling'])->name('api.dashboard.kavling');
    });
});
