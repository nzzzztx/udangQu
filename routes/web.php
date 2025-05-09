<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GajiController;


// Route untuk mencetak laporan gaji dalam bentuk PDF
Route::get('/laporan-gaji/pdf', [GajiController::class, 'exportPdf'])
    ->name('laporan.gaji.pdf');

// Route default untuk halaman awal aplikasi
Route::get('/', function () {
    return view('welcome');
});
