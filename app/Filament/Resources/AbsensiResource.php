<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Filament\Resources\AbsensiResource\RelationManagers;
use App\Models\Absensi;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


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
        return $form
            ->schema([
                TextInput::make('nama_karyawan')
                    ->required()
                    ->label('Nama'),
                TextInput::make('tanggal_absensi')
                    ->required()
                    ->label('Tanggal Absensi'),
                TextInput::make('jam_masuk')
                    ->required()    
                    ->numeric()
                    ->label('Jam Masuk'),
                TextInput::make('keterangan_absensi')
                    ->required()
                    ->label('Keterangan Absensi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_karyawan')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Karyawan'),
                TextColumn::make('tanggal_absensi')
                    ->label('Tanggal Absensi'),
                TextColumn::make('jam_masuk')
                    ->label('Jam Masuk'),
                TextColumn::make('keterangan_absensi')
                    ->label('Keterangan Absensi'),
            ])
            ->filters([
                //
            ])
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
        return [
            //
        ];
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
