<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Keuangan;
use Carbon\Carbon;
use Filament\Forms;

class FinancialChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Keuangan';
    public ?int $tahun = null;

    protected function getData(): array
    {
        $tahun = $this->tahun ?? now()->year;

        $data = Keuangan::selectRaw("
                strftime('%m', tanggal) as bulan,
                SUM(CASE WHEN jenis = 'masuk' THEN jumlah ELSE 0 END) as pemasukan,
                SUM(CASE WHEN jenis = 'keluar' THEN jumlah ELSE 0 END) as pengeluaran
            ")
            ->whereYear('tanggal', $tahun)
            ->groupByRaw("strftime('%m', tanggal)")
            ->orderByRaw("strftime('%m', tanggal)")
            ->get();

        $months = collect(range(1, 12));

        $dataByMonth = $months->mapWithKeys(function ($month) use ($data) {
            $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT);
            $monthData = $data->firstWhere('bulan', $monthFormatted);

            return [
                $month => [
                    'pemasukan'   => $monthData->pemasukan ?? 0,
                    'pengeluaran' => $monthData->pengeluaran ?? 0,
                ],
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $dataByMonth->pluck('pemasukan')->values(),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.7)',
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $dataByMonth->pluck('pengeluaran')->values(),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.7)',
                ],
            ],
            'labels' => $months->map(fn ($m) => Carbon::create()->month($m)->translatedFormat('F')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('tahun')
                ->label('Pilih Tahun')
                ->options(
                    collect(range(now()->year - 5, now()->year))
                        ->mapWithKeys(fn ($year) => [$year => $year])
                        ->reverse()
                        ->toArray()
                )
                ->default(now()->year)
                ->reactive()
                ->afterStateUpdated(fn () => $this->updateChartData()),
        ];
    }
}
