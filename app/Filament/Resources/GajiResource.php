<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GajiResource\Pages;
use App\Models\Gaji;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\URL;
use App\Models\Absensi;

use function Laravel\Prompts\form;

class GajiResource extends Resource
{
    protected static ?string $model = Gaji::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Data Gaji';
    protected static ?string $navigationGroup = 'Kelola Data';
    protected static ?string $slug = 'data-gaji';
    public static ?string $label = 'Kelola Gaji';

    /**
     * Form schema untuk input data Gaji
     */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('karyawan_id')
                ->label('Nama Karyawan')
                ->relationship(
                    name: 'tb_karyawan',
                    titleAttribute: 'nama',
                    modifyQueryUsing: fn ($query) => $query->where('active_st', true),
                )
                ->searchable()
                ->required(),

            Forms\Components\Select::make('bulan')
                ->label('Bulan Gaji')
                ->required()
                ->options([
                    '01' => 'Januari',
                    '02' => 'Februari',
                    '03' => 'Maret',
                    '04' => 'April',
                    '05' => 'Mei',
                    '06' => 'Juni',
                    '07' => 'Juli',
                    '08' => 'Agustus',
                    '09' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember',
                ]),

            Forms\Components\Select::make('tahun')
                ->label('Tahun Gaji')
                ->required()
                ->options(
                    collect(range(2020, now()->year))
                        ->mapWithKeys(fn ($year) => [$year => $year])
                        ->toArray()
                ),
                Forms\Components\TextInput::make('gaji_harian')
                    ->label('Gaji Harian')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->prefix('Rp')
                    ->default(0)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $absen = $get('total_absen');
                        if (is_numeric($state) && is_numeric($absen)) {
                            $set('total_gaji', $state * $absen);
                        }
                    }),

                Forms\Components\TextInput::make('total_absen')
                    ->label('Total Absen')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->default(0)
                    ->readOnly()
                    ->suffixAction(
                        Forms\Components\Actions\Action::make('Cek')
                            ->label('Cek')
                            ->icon('heroicon-o-magnifying-glass')
                            ->action(function (callable $get, callable $set) {
                                $karyawanId = $get('karyawan_id');
                                $bulan = $get('bulan');
                                $tahun = $get('tahun');

                                if (!$karyawanId || !$bulan || !$tahun) {
                                    return;
                                }

                                // Konversi string ke integer agar bisa dibandingkan di whereMonth
                                $bulanInt = (int) ltrim($bulan, '0');

                                $totalAbsen = \App\Models\Absensi::query()
                                    ->where('karyawan_id', $karyawanId)
                                    ->whereMonth('tanggal_absensi', $bulanInt)
                                    ->whereYear('tanggal_absensi', $tahun)
                                    ->where('keterangan_absensi', 'hadir') // sesuaikan jika perlu
                                    ->count();
                                // dd($totalAbsen);
                                $set('total_absen', $totalAbsen);

                                $gajiPerHari = $get('gaji_harian') ?? 0;
                                $set('total_gaji', $gajiPerHari * $totalAbsen);
                            })
                    )
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $gajiPerHari = $get('gaji_harian');
                    if (is_numeric($state) && is_numeric($gajiPerHari)) {
                        $set('total_gaji', $state * $gajiPerHari);
                    }
                }),


                // Forms\Components\TextInput::make('total_absen')
                //     ->label('Total Absen')
                //     ->numeric()
                //     ->required()
                //     ->reactive()
                //     ->default(0)
                //     ->afterStateUpdated(function ($state, callable $set, callable $get) {
                //         $harian = $get('gaji_harian');
                //         if (is_numeric($state) && is_numeric($harian)) {
                //             $set('total_gaji', $state * $harian);
                //         }
                // }),

                Forms\Components\TextInput::make('total_gaji')
                    ->label('Total Gaji')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0)
                    ->readOnly(),
                // ->afterStateUpdated(function (callable $set, $state, $get) {
                //     $karyawanId = $get('karyawan_id');
                //     $bulan = $get('bulan');
                //     $tahun = $get('tahun');

                //     // Hitung total absensi dari tabel absensi
                //     $totalAbsensi = Absensi::table('absensi')
                //         ->where('karyawan_id', $karyawanId)
                //         ->where('bulan', $bulan)
                //         ->where('tahun', $tahun)
                //         ->count();

                //     // Set nilai total absensi
                //     $set('total_absensi', $totalAbsensi);

                //     // Hitung total gaji
                //     $gajiPerHari = $get('gaji_per_hari');
                //     $totalGaji = $totalAbsensi * $gajiPerHari;

                //     // Set nilai total gaji
                //     $set('total_gaji', $totalGaji);
                // }),
        ]);
    }

    /**
     * Menentukan tabel yang menampilkan data Gaji
     */
    public static function table(Table $table): Table
    {
        return $table
            ->query(fn (\App\Models\Gaji $query) => $query->with('tb_karyawan'))
            ->columns([
                Tables\Columns\TextColumn::make('tb_karyawan.nama')
                    ->label('Karyawan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bulan')
                    ->label('Bulan')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                        default => '-',
                    }),

                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->date('Y'),

                Tables\Columns\TextColumn::make('total_gaji')
                    ->label('Total Gaji')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('gaji_harian')
                    ->label('Gaji Harian')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('total_absen')
                    ->label('Total Absen')
                    ,
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('Cetak Laporan Gaji')
                    ->url(fn () => URL::route('laporan.gaji.pdf'))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-printer')
                    ->label('Cetak Laporan Gaji'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    /**
     * Menentukan relasi untuk resource ini
     */
    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi jika diperlukan
        ];
    }

    /**
     * Menentukan halaman-halaman yang tersedia pada resource ini
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGajis::route('/'),
            'create' => Pages\CreateGaji::route('/create'),
            'edit' => Pages\EditGaji::route('/{record}/edit'),
        ];
    }
}
