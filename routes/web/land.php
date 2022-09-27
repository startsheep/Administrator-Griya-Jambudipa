<?php

use App\Http\Controllers\Export\LandController;
use Illuminate\Support\Facades\Route;

Route::prefix('export/land')->group(function () {
    Route::controller(LandController::class)->group(function () {
        Route::get('/pdf', 'pdf')->name('web.export.land.pdf');
        Route::get('/excel', 'excel')->name('web.export.land.excel');
        Route::get('/print', 'print')->name('web.export.land.print');
    });
});
