<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksistockResource\Pages;
use App\Filament\Resources\TransaksistockResource\RelationManagers;
use App\Models\Transaksistock;
use Filament\Forms\Components\Select;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;

class TransaksistockResource extends Resource
{
    protected static ?string $model = Transaksistock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Data Transaksi ';

    protected static ?string $navigationGroup = 'Kelola Data';

    protected static ?string $slug = 'data-transaksi-stock';

    public static ?string $label = 'Kelola Transaksi Stock';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('Barang_id')
                    ->required()
                    ->label('Nama Barang')
                    ->placeholder('Masukan nama barang'),

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

                Forms\Components\DatePicker::make('tanggal_transaksi')
                    ->label('Tanggal')
                    ->default(Carbon::now())
                    ->required(),

                Forms\Components\TextInput::make('jumlah_barang')
                    ->label('Jumlah Barang')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('Masukan jumlah barang'),

                    Forms\Components\TextInput::make('harga_barang')
                    ->label('harga barang')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->prefix('Rp')
                    ->default(0)
                    ->placeholder('Masukan harga barang'),

                    Forms\Components\TextInput::make('jumlah_stock')
                    ->label('Jumlah Stock')
                    ->required()        
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('Masukan jumlah stock'),

                    Forms\Components\TextInput::make('sisa_stock')
                    ->label('Sisa Stock')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('Masukan sisa stock'),

                    TextInput::make('Keterangan_barang')
                    ->label('Catatan')
                    ->placeholder('Masukan keterangan barang'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tb_karyawan.nama')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_transaksi')
                    ->label('Tanggal Transaksi')
                    ->date(),

                Tables\Columns\TextColumn::make('jumlah_barang')
                    ->label('Jumlah Barang')
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga_barang')     
                    ->label('Harga Barang')
                    ->sortable()
                    ->money('IDR', true)
                    ->prefix('Rp')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.')),

                Tables\Columns\TextColumn::make('jumlah_stock')
                    ->label('Jumlah Stock')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sisa_stock')
                    ->label('Sisa Stock')
                    ->sortable(),

                Tables\Columns\TextColumn::make('Keterangan_barang')
                    ->label('Keterangan Barang')
                    ->limit(50)
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
            'index' => Pages\ListTransaksistocks::route('/'),
            'create' => Pages\CreateTransaksistock::route('/create'),
            'edit' => Pages\EditTransaksistock::route('/{record}/edit'),
        ];
    }
}
