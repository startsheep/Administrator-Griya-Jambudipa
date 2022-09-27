<?php

use App\Http\Controllers\Export\KavlingController;
use Illuminate\Support\Facades\Route;

Route::prefix('export/kavling')->group(function () {
    Route::controller(KavlingController::class)->group(function () {
        Route::get('/pdf/{block}', 'pdf')->name('web.export.kavling.pdf');
        Route::get('/excel/{block}', 'excel')->name('web.export.kavling.excel');
        Route::get('/print/{block}', 'print')->name('web.export.kavling.print');
    });
});
