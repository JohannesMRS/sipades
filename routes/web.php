<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::view('/apbdes', 'pages.apbdes')->name('apbdes');
Route::view('/realisasi-anggaran', 'pages.realisasi')->name('realisasi');
Route::view('/informasi-pembangunan', 'pages.pembangunan')->name('pembangunan');
Route::view('/dokumen-publik', 'pages.dokumen')->name('dokumen');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');
