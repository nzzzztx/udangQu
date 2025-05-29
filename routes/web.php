<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\AbsensiScanController;


// Route untuk mencetak laporan gaji dalam bentuk PDF
Route::get('/laporan-gaji/pdf', [GajiController::class, 'exportPdf'])
    ->name('laporan.gaji.pdf');
Route::post('/absensi-scan', [AbsensiScanController::class, 'store'])
    ->name('absensi.scan');

// Route default untuk halaman awal aplikasi
Route::get('/', function () {
    return redirect('/admin/login');
});
