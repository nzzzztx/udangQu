<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Models\Absensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Carbon\Carbon;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Data Absensi';
    protected static ?string $navigationGroup = 'Kelola Data';
    protected static ?string $slug = 'data-absensi';
    public static ?string $label = 'Kelola Absensi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('karyawan_id')
                ->label('Nama Karyawan')
                ->relationship('tb_karyawan', 'nama')
                ->searchable()
                ->required()
                ->relationship(
                    name: 'tb_karyawan',
                    titleAttribute: 'nama',
                    modifyQueryUsing: fn ($query) => $query->where('active_st', true),
                ),

            Forms\Components\DatePicker::make('tanggal_absensi')
                ->label('Tanggal')
                 ->default(Carbon::now())
                ->required(),

            Forms\Components\TimePicker::make('jam_masuk')
                ->required()
                //  ->native(false)
                 ->displayFormat('H:i')
                 ->default(Carbon::now()->format('H:i'))
                ->label('Jam Masuk'),

            Forms\Components\TimePicker::make('jam_keluar')
                // ->required()
                //  ->native(false)
                 ->displayFormat('H:i')
                ->label('Jam Keluar'),

            Select::make('keterangan_absensi')
                ->label('Keterangan Absensi')
                ->required()
                ->options([
                    'hadir' => 'Hadir',
                    'tidak hadir' => 'Tidak Hadir',
                ])
                ->native(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tb_karyawan.nama')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal_absensi')
                    ->label('Tanggal Absensi'),

                TextColumn::make('jam_masuk')
                    ->label('Jam Masuk'),

                TextColumn::make('jam_keluar')
                    ->label('Jam Keluar'),

                TextColumn::make('keterangan_absensi')
                    ->label('Keterangan Absensi')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'hadir' => 'Hadir',
                        'tidak hadir' => 'Tidak Hadir',
                        default => ucfirst($state),
                    })
                    ->color(fn ($state) => match ($state) {
                        'hadir' => 'success',
                        'tidak hadir' => 'danger',
                        default => 'secondary',
                    }),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }
}
