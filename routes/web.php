<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Str;


route::get('/', [HomeController::class, 'index'])->name('index');
Route::view('/apbdes', 'pages.apbdes')->name('apbdes');
Route::view('/realisasi-anggaran', 'pages.realisasi')->name('realisasi');
Route::view('/informasi-pembangunan', 'pages.pembangunan')->name('pembangunan');
Route::view('/dokumen-publik', 'pages.dokumen')->name('dokumen');
Route::view('/berita', 'pages.berita')->name('berita');
Route::get('/berita/{slug}', function (string $slug) {
    $item = collect(config('village.news'))->first(fn ($n) => Str::slug($n['title']) === $slug);
    abort_unless($item, 404);
    return view('pages.berita-show', ['item' => $item]);
})->name('berita.show');
