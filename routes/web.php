<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\transparansi\ApbdesController;
use App\Http\Controllers\transparansi\DokumenController;
use App\Http\Controllers\transparansi\PembangunanController;
use App\Http\Controllers\transparansi\RealisasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/apbdes', ApbdesController::class)->name('apbdes');
Route::get('/realisasi-anggaran', RealisasiController::class)->name('realisasi');
Route::get('/informasi-pembangunan', PembangunanController::class)->name('pembangunan');
Route::get('/dokumen-publik', DokumenController::class)->name('dokumen');
Route::get('/dokumen-publik/{dokumen}/unduh', [DokumenController::class, 'download'])->name('dokumen.download');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');
