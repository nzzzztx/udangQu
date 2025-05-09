<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Barryvdh\DomPDF\Facade\Pdf;

class GajiController extends Controller
{
    /**
     * Ekspor laporan gaji ke dalam bentuk PDF.
     */
    public function exportPdf()
    {
        // Ambil semua data gaji beserta relasi karyawan
        $gajiSemua = Gaji::with('karyawan')->get();

        // Kelompokkan data: Nama Karyawan → Bulan → Total Gaji per Bulan
        $gajiPerKaryawan = $gajiSemua->groupBy(function ($gaji) {
                return $gaji->karyawan->nama;
            })->map(function ($gajiKaryawan) {
                return $gajiKaryawan->groupBy('bulan')
                    ->map(function ($gajiPerBulan) {
                        return $gajiPerBulan->sum('total_gaji');
                    });
            });

        // Hitung total gaji keseluruhan
        $totalKeseluruhan = $gajiSemua->sum('total_gaji');

        // Generate PDF dengan Blade view
        $pdf = Pdf::loadView('laporan.laporan_gaji', [
            'gajiPerKaryawan'   => $gajiPerKaryawan,
            'totalKeseluruhan'  => $totalKeseluruhan,
        ]);

        // Unduh PDF dengan nama file 'laporan-gaji.pdf'
        return $pdf->download('laporan-gaji.pdf');
    }
}
