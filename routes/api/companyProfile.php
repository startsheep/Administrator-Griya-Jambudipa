<?php

use App\Http\Controllers\API\CompanyProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('company-profile')->group(function () {
        Route::get('/', [CompanyProfileController::class, 'index'])->name('api.company.profile.index');
        Route::put('/{id}', [CompanyProfileController::class, 'update'])->name('api.company.profile.update');
    });
});
