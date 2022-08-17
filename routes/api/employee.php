<?php

use App\Http\Controllers\API\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('employee')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('api.employee.index');
        Route::post('/', [EmployeeController::class, 'store'])->name('api.employee.store');
        Route::get('/{id}', [EmployeeController::class, 'show'])->name('api.employee.show');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('api.employee.update');
        Route::delete('/{id}', [EmployeeController::class, 'delete'])->name('api.employee.delete');
    });
});
