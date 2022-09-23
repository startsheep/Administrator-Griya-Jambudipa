<?php

use App\Http\Controllers\API\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/count-customer', [DashboardController::class, 'countCustomer'])->name('api.dashboard.count.customer');
        Route::get('/count-employee', [DashboardController::class, 'countEmployee'])->name('api.dashboard.count.employee');
        Route::get('/count-contractor', [DashboardController::class, 'countContractor'])->name('api.dashboard.count.contractor');
        Route::get('/count-kavling', [DashboardController::class, 'countKavling'])->name('api.dashboard.count.kavling');
        Route::get('/count-house-type', [DashboardController::class, 'countHouseType'])->name('api.dashboard.count.house.type');
        Route::get('/count-transaction', [DashboardController::class, 'countTransaction'])->name('api.dashboard.count.transaction');
        Route::get('/count-profit', [DashboardController::class, 'countProfit'])->name('api.dashboard.count.profit');
        Route::get('/count-whole-job', [DashboardController::class, 'countWholeJob'])->name('api.dashboard.count.whole.job');
        Route::get('/kavling', [DashboardController::class, 'kavling'])->name('api.dashboard.kavling');
        Route::get('/graph', [DashboardController::class, 'graph'])->name('api.dashboard.graph');
    });
});
