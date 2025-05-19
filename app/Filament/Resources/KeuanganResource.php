<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeuanganResource\Pages;
use App\Filament\Resources\KeuanganResource\RelationManagers;
use App\Models\Keuangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeuanganResource extends Resource
{
    protected static ?string $model = Keuangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Data Keuangan';

    protected static ?string $navigationGroup = 'Kelola Data';

    protected static ?string $slug = 'data-keuangan';

    public static ?string $label = 'Kelola Keuangan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('jenis')
                ->label('Jenis Transaksi')
                ->options([
                    'masuk' => 'Pemasukan',
                    'keluar' => 'Pengeluaran',
                ])
                ->required(),

            Forms\Components\TextInput::make('jumlah')
                ->label('Jumlah')
                ->required()
                ->numeric()
                ->prefix('Rp'),

            Forms\Components\TextInput::make('keterangan')
                ->label('Keterangan'),

            Forms\Components\DatePicker::make('tanggal')
                ->label('Tanggal')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                ->date(),

                Tables\Columns\TextColumn::make('jenis')
                ->label('Jenis')
                ->badge()
                ->colors([
                    'masuk' => 'success',
                    'keluar' => 'danger',
                ])
                ->formatStateUsing(fn (string $state) => ucfirst($state)),

                Tables\Columns\TextColumn::make('jumlah')
                ->label('Jumlah')
                ->money('IDR'),

                Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan'),
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
            'index' => Pages\ListKeuangans::route('/'),
            'create' => Pages\CreateKeuangan::route('/create'),
            'edit' => Pages\EditKeuangan::route('/{record}/edit'),
        ];
    }
}