<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangstockResource\Pages;
use App\Filament\Resources\BarangstockResource\RelationManagers;
use App\Models\Barangstock;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangstockResource extends Resource
{
    protected static ?string $model = Barangstock::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Data Barang';
    protected static ?string $navigationGroup = 'Kelola Data';
    protected static ?string $slug = 'data-barang-stock';
    public static ?string $label = 'Kelola Barang Stock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_barang')
                    ->required()
                    ->label('Nama Barang')
                    ->placeholder('Masukan nama barang'),
                
                Forms\Components\DatePicker::make('tanggal_stock')
                    ->label('Tanggal Stock')
                    ->default(now())
                    ->required(),

                Select::make('satuan')
                    ->label('Jumlah Satuan')
                    ->required()
                    ->placeholder('Masukan jumlah satuan')
                    ->options([
                        'kg' => 'Kilogram',
                        'pcs' => 'Pcs',
                        'pack' => 'Pack',
                        'box' => 'Box',
                        'gram' => 'Gram',
                    ]),
                
                Forms\Components\TextInput::make('jumlah_stock')
                    ->label('Jumlah Stock')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->placeholder('Masukan jumlah Stock'),
                
                Forms\Components\TextInput::make('harga_barang')
                    ->label('Harga Barang')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->placeholder('Masukan harga barang'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('tanggal_stock')
                    ->label('Tanggal Stock')
                    ->date(),

                Tables\Columns\TextColumn::make('jumlah_stock')
                    ->label('Jumlah Stock')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('jumlah_satuan')
                    ->label('Jumlah Satuan')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('harga_barang')
                    ->label('Harga Barang')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

            ])
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
            'index' => Pages\ListBarangstocks::route('/'),
            'create' => Pages\CreateBarangstock::route('/create'),
            'edit' => Pages\EditBarangstock::route('/{record}/edit'),
        ];
    }
}
