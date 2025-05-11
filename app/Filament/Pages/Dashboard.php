<?php

namespace App\Filament\Pages;

use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Keuangan;
use Carbon\Carbon;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $title = 'Dashboard';

    /**
     * Mendapatkan jumlah total karyawan.
     */
    public function getJumlahKaryawan(): int
    {
        return Karyawan::count();
    }

    /**
     * Mendapatkan jumlah absensi hari ini.
     */
    public function getAbsensiHariIni(): int
    {
        return Absensi::whereDate('tanggal_absensi', Carbon::today())->count();
    }

    /**
     * Menghitung persentase kehadiran hari ini.
     */
    public function getPersentaseHadir(): int
    {
        $totalKaryawan = $this->getJumlahKaryawan();
        $jumlahHadir = Absensi::whereDate('tanggal_absensi', Carbon::today())
            ->where('keterangan_absensi', 'hadir')
            ->count();

        if ($totalKaryawan === 0) {
            return 0;
        }

        return intval(($jumlahHadir / $totalKaryawan) * 100);
    }

    /**
     * Mengambil 5 data absensi terbaru beserta relasi karyawan.
     */
    public function getAbsensiTerbaru()
    {
        return Absensi::with('karyawan')
            ->latest()
            ->limit(5)
            ->get();
    }

    /**
     * Menghitung total pemasukan bulan ini dari tabel keuangan.
     */
    public function getTotalPemasukan(): int
    {
        return Keuangan::where('jenis', 'masuk')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah');
    }

    /**
     * Menghitung total pengeluaran bulan ini dari tabel keuangan.
     */
    public function getTotalPengeluaran(): int
    {
        return Keuangan::where('jenis', 'keluar')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah');
    }

    /**
     * Mendefinisikan widget yang akan ditampilkan di halaman dashboard.
     */
    public static function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\FinancialChart::class,
        ];
    }
}