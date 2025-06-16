<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    /**
     * Ekspor laporan gaji ke dalam bentuk PDF.
     */
    public function exportPdf(Request $request)
    {
        $id = $request->input('id');
        // Ambil semua data gaji beserta relasi karyawan
        // $gajiSemua = Gaji::with('tb_karyawan')->get();

        // Get data Gaji by Id
        $data = Gaji::select('gajis.*', 'tb_karyawans.*')
                ->leftJoin('tb_karyawans', 'gajis.karyawan_id', '=', 'tb_karyawans.karyawan_id')
                ->where('gajis.id', $id)
                ->firstOrFail();
        // dd($data->tahun);

        // Kelompokkan data: Nama Karyawan → Bulan → Total Gaji per Bulan
        // $gajiPerKaryawan = $gajiSemua->groupBy(function ($gaji) {
        //         return $gaji->tb_karyawan->nama;
        //     })->map(function ($gajiKaryawan) {
        //         return $gajiKaryawan->groupBy('bulan')
        //             ->map(function ($gajiPerBulan) {
        //                 return $gajiPerBulan->sum('total_gaji');
        //             });
        //     });

        // Hitung total gaji keseluruhan
        // $totalKeseluruhan = $gajiSemua->sum('total_gaji');

        // Generate PDF dengan Blade view
        $pdf = Pdf::loadView('laporan.laporan_gaji', [
            'data'   => $data,
        ]);

        // Preview PDF dengan nama file 'laporan-gaji.pdf'
        return $pdf->stream('laporan-gaji.pdf');
        // Unduh PDF dengan nama file 'laporan-gaji.pdf'
        // return $pdf->download('laporan-gaji.pdf');
    }
}
