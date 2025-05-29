<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Tb_karyawan;
use Carbon\Carbon;

class AbsensiScanController extends Controller
{
     public function store(Request $request)
    {
        $qrCode = $request->input('qr_code');

        if (!$qrCode) {
            return response()->json(['message' => 'QR Code tidak valid'], 400);
        }

        $karyawan = \App\Models\Tb_karyawan::where('qr_code', $qrCode)->first();

        if (!$karyawan) {
            return response()->json(['message' => 'Karyawan tidak ditemukan'], 404);
        }

        $today = Carbon::today()->toDateString();

        $sudahAbsen = Absensi::where('karyawan_id', $karyawan->karyawan_id)
            ->whereDate('tanggal_absensi', $today)
            ->exists();

        if ($sudahAbsen) {
            return response()->json(['message' => 'Karyawan sudah absen hari ini'], 200);
        }

        Absensi::create([
            'karyawan_id' => $karyawan->karyawan_id,
            'tanggal_absensi' => $today,
            'jam_masuk' => Carbon::now()->format('H:i:s'),
            'keterangan_absensi' => 'hadir',
        ]);

        return response()->json(['message' => 'Absensi berhasil dicatat'], 201);
    }
}
