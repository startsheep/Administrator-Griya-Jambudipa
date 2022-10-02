<?php

use App\Http\Controllers\Export\JobHouseController;
use Illuminate\Support\Facades\Route;

Route::prefix('export/job-house')->group(function () {
    Route::controller(JobHouseController::class)->group(function () {
        Route::get('/pdf', 'pdf')->name('web.export.job.house.pdf');
        Route::get('/excel', 'excel')->name('web.export.job.house.excel');
        Route::get('/print', 'print')->name('web.export.job.house.print');
    });
});
