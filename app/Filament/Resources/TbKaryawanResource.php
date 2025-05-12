<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TbKaryawanResource\Pages;
use App\Filament\Resources\TbKaryawanResource\RelationManagers;
use App\Models\Tb_karyawan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Radio;

class TbKaryawanResource extends Resource
{
    protected static ?string $model = Tb_karyawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Data Karyawan';

    protected static ?string $navigationGroup = 'Kelola Data';

    public static ?string $label = 'Kelola Karyawan';

    public static function getNavigationSort(): int
    {
        return 3; // Tengah
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama')
                    ->placeholder('Masukan nama karyawan'),
                Select::make('jenis_kelamin')
                    ->required()
                    ->label('Jenis Kelamin')
                    ->placeholder('Pilih Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
                Textarea::make('alamat_karyawan')
                    ->required()
                    ->label('Alamat')
                    ->placeholder('Masukan Alamat')
                    ->rows(3),
                Radio::make('active_st')
                    ->label('Status')
                    ->options([
                        true => 'Aktif',
                        false => 'Tidak Aktif',
                    ])
                    // ->boolean()
                    ->default(true)
                    ->inline() // opsional: tampil horizontal
                    ->required(),
                TextInput::make('no_telepon')
                    ->required()
                    ->label('Telepon')
                    ->numeric()
                    ->maxLength(13)
                    ->placeholder('Masukan nomer telepon'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
                ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan')
                    ->sortable(),

                TextColumn::make('alamat_karyawan')
                    ->label('Alamat')
                    ->limit(30), // batasi panjang teks

                TextColumn::make('no_telepon')
                    ->label('Telepon'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
                TextColumn::make('active_st')
                    ->label('Status')
                    ->badge() // tampilkan sebagai badge
                    ->icon(fn ($state) => $state ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->iconColor(fn ($state) => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Tidak Aktif')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTbKaryawans::route('/'),
            'create' => Pages\CreateTbKaryawan::route('/create'),
            'edit' => Pages\EditTbKaryawan::route('/{record}/edit'),
        ];
    }
}
