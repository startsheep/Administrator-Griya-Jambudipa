<?php

use App\Http\Controllers\Export\CustomerController;
use Illuminate\Support\Facades\Route;

Route::prefix('export/customer')->group(function () {
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/pdf', 'pdf')->name('web.export.customer.pdf');
        Route::get('/excel', 'excel')->name('web.export.customer.excel');
        Route::get('/print', 'print')->name('web.export.customer.print');
    });
});
