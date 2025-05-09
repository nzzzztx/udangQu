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
                ->relationship('karyawan', 'nama')
                ->required()
                ->searchable(),

            Forms\Components\DatePicker::make('bulan')
                ->label('Bulan Gaji')
                ->required()
                ->format('Y-m'),

            Forms\Components\TextInput::make('total_gaji')
                ->label('Total Gaji')
                ->required()
                ->numeric()
                ->prefix('Rp'),
        ]);
    }

    /**
     * Menentukan tabel yang menampilkan data Gaji
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('karyawan.nama')
                    ->label('Karyawan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bulan')
                    ->label('Bulan')
                    ->date('F Y'),

                Tables\Columns\TextColumn::make('total_gaji')
                    ->label('Total Gaji')
                    ->money('IDR'),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tambahkan aksi untuk mencetak laporan PDF
                Action::make('Cetak Laporan Gaji')
                    ->url(fn () => URL::route('laporan.gaji.pdf'))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-printer')
                    ->label('Cetak Laporan Gaji')
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
