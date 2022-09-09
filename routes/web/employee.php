<?php

use App\Http\Controllers\Export\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::prefix('export/employee')->group(function () {
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/pdf', 'pdf')->name('web.export.employee.pdf');
        Route::get('/excel', 'excel')->name('web.export.employee.excel');
        Route::get('/print', 'print')->name('web.export.employee.print');
    });
});
