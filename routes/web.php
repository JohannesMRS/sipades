<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

route::get('/', [HomeController::class, 'index'])->name('index');
Route::view('/apbdes', 'pages.apbdes')->name('apbdes');
Route::view('/realisasi-anggaran', 'pages.realisasi')->name('realisasi');
Route::view('/informasi-pembangunan', 'pages.pembangunan')->name('pembangunan');
Route::view('/dokumen-publik', 'pages.dokumen')->name('dokumen');
