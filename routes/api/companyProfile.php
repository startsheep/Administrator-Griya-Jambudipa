<?php

use App\Http\Controllers\API\CompanyProfileController;
use Illuminate\Support\Facades\Route;

Route::get('company-profile', [CompanyProfileController::class, 'index'])->name('api.company.profile.index');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('company-profile')->group(function () {
        Route::put('/{id}', [CompanyProfileController::class, 'update'])->name('api.company.profile.update');
    });
});
