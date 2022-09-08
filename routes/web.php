<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

includeRouteFiles(__DIR__ . '/web');

Route::get('/{any}', [PageController::class, 'index'])->where('any', '^(?!auth|export).*$');
Route::prefix('/auth')->group(function () {
    Route::get('/', [PageController::class, 'auth'])->name('web.login');
    Route::get('/{any}', [PageController::class, 'auth']);
});
