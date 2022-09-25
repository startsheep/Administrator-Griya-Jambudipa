<?php

use App\Http\Controllers\API\WholeJobController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('whole-job')->group(function () {
        Route::get('/', [WholeJobController::class, 'index'])->name('api.whole.job.index');
        Route::post('/', [WholeJobController::class, 'store'])->name('api.whole.job.store');
        Route::get('/{id}', [WholeJobController::class, 'show'])->name('api.whole.job.show');
        Route::put('/{id}', [WholeJobController::class, 'update'])->name('api.whole.job.update');
        Route::delete('/{id}', [WholeJobController::class, 'delete'])->name('api.whole.job.delete');
        Route::post('/payment/{id}', [WholeJobController::class, 'payment'])->name('api.whole.job.payment');
    });
});
