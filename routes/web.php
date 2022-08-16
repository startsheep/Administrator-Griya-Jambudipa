<?php

use App\Http\Controllers\AuthController;
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


Route::get('/', AuthController::class)->name('web.auth.login')->middleware('guest');

   Route::get('dashboard',function(){
    return view('pages.dashboard');
});

