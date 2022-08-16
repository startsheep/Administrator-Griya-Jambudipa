<?php

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

// Semua route akan disimpan di folder url, nama sesuai route sesaui dengan nama feature

includeRouteFiles(__DIR__ . '/url');

// Semua route akan disimpan di folder url selain route utama dibawah ini
Route::get('/', function () {
    return view('pages.dashboard');
});
Route::get('/pegawai', function () {
    return view('pages.pegawai.v-pegawai');
});

