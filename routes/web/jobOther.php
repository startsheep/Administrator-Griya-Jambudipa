<?php

use App\Http\Controllers\Export\JobOtherController;
use Illuminate\Support\Facades\Route;

Route::prefix('export/job-other')->group(function () {
    Route::controller(JobOtherController::class)->group(function () {
        Route::get('/pdf', 'pdf')->name('web.export.job.other.pdf');
        Route::get('/excel', 'excel')->name('web.export.job.other.excel');
        Route::get('/print', 'print')->name('web.export.job.other.print');
    });
});
