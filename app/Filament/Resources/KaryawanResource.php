<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaryawanResource\Pages;
use App\Filament\Resources\KaryawanResource\RelationManagers;
use App\Models\Karyawan;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KaryawanResource extends Resource
{
    protected static ?string $model = Karyawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Data Petani';

    protected static ?string $navigationGroup = 'Kelola Data';

    protected static ?string $slug = 'data-karyawan';

    public static ?string $label = 'Kelola Petani';

    public static function shouldRegisterNavigation(): bool
    {
        return false; //  menyembunyikan resource dari sidebar
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama')
                    ->placeholder('Masukan nama karyawan'),
                TextInput::make('jenis_kelamin')
                    ->required()
                    ->label('Jenis Kelamin')
                    ->placeholder('Masukan Jenis Kelamin'),
                TextInput::make('alamat_karyawan')
                    ->required()
                    ->label('Alamat')
                    ->placeholder('Masukan Alamat'),
                TextInput::make('no_telepon')
                    ->required()
                    ->label('Telepon')
                    ->numeric()
                    ->placeholder('Masukan nomer telepon'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin'),
                TextColumn::make('alamat_karyawan')
                    ->copyMessage('Alamat berhasil disalin')
                    ->label('Alamat'),
                TextColumn::make('no_telepon')
                    ->copyMessage('Nomor telepon berhasil disalin')
                    ->label('Telepon'),
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
            'index' => Pages\ListKaryawans::route('/'),
            'create' => Pages\CreateKaryawan::route('/create'),
            'edit' => Pages\EditKaryawan::route('/{record}/edit'),
        ];
    }
}