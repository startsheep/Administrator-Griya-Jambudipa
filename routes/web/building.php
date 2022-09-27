<?php

use App\Http\Controllers\Export\BuildingController;
use Illuminate\Support\Facades\Route;

Route::prefix('export/building')->group(function () {
    Route::controller(BuildingController::class)->group(function () {
        Route::get('/pdf', 'pdf')->name('web.export.building.pdf');
        Route::get('/excel', 'excel')->name('web.export.building.excel');
        Route::get('/print', 'print')->name('web.export.building.print');
    });
});
