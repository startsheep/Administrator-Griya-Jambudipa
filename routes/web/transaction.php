<?php

use App\Http\Controllers\Export\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('export/transaction')->group(function () {
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/pdf', 'pdf')->name('web.export.transaction.pdf');
        Route::get('/excel', 'excel')->name('web.export.transaction.excel');
        Route::get('/print', 'print')->name('web.export.transaction.print');
    });
});
