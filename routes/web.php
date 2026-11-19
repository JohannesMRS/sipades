<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\transparansi\ApbdesController;
use App\Http\Controllers\transparansi\RealisasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/apbdes', ApbdesController::class)->name('apbdes');
Route::get('/realisasi-anggaran', RealisasiController::class)->name('realisasi');
Route::view('/informasi-pembangunan', 'pages.pembangunan')->name('pembangunan');
Route::view('/dokumen-publik', 'pages.dokumen')->name('dokumen');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');
