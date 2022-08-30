<?php

use App\Http\Controllers\API\ContractorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('contractor')->group(function () {
        Route::get('/', [ContractorController::class, 'index'])->name('api.contractor.index');
        Route::post('/', [ContractorController::class, 'store'])->name('api.contractor.store');
        Route::get('/{id}', [ContractorController::class, 'show'])->name('api.contractor.show');
        Route::put('/{id}', [ContractorController::class, 'update'])->name('api.contractor.update');
        Route::delete('/{id}', [ContractorController::class, 'delete'])->name('api.contractor.delete');
        Route::put('/active/{id}', [ContractorController::class, 'updateActive'])->name('api.contractor.update.active');
    });
});
