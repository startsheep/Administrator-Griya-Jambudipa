<?php

use App\Http\Controllers\Export\ContractorController;
use Illuminate\Support\Facades\Route;

Route::prefix('export/contractor')->group(function () {
    Route::controller(ContractorController::class)->group(function () {
        Route::get('/pdf', 'pdf')->name('web.export.contractor.pdf');
        Route::get('/excel', 'excel')->name('web.export.contractor.excel');
        Route::get('/print', 'print')->name('web.export.contractor.print');
    });
});
