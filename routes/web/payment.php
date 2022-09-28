<?php

use App\Http\Controllers\Export\PaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix('export/payment')->group(function () {
    Route::controller(PaymentController::class)->group(function () {
        Route::get('/pdf', 'pdf')->name('web.export.payment.pdf');
        Route::get('/excel', 'excel')->name('web.export.payment.excel');
        Route::get('/print', 'print')->name('web.export.payment.print');
    });
});
