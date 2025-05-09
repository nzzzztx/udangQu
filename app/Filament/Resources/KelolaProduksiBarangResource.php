<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelolaProduksiBarangResource\Pages;
use App\Models\KelolaProduksiBarang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KelolaProduksiBarangResource extends Resource
{
    protected static ?string $model = KelolaProduksiBarang::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Produksi Barang';
    protected static ?string $pluralModelLabel = 'Produksi Barang';
    protected static ?string $navigationGroup = 'Kelola Data';
    public static ?string $label = 'Kelola Produksi Barang';
    protected static ?string $slug = 'data-produksi-barang';

    /**
     * Form untuk input data produksi barang
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('petani_id') // gunakan field yang sesuai dengan DB
                    ->relationship('petani', 'nama')       // relasi ke model Karyawan
                    ->searchable()
                    ->required()
                    ->label('Nama Petani'),

                Forms\Components\DatePicker::make('tanggal_produksi')
                    ->required()
                    ->label('Tanggal Produksi'),
                
                Forms\Components\TextInput::make('nama_barang')
                    ->required()
                    ->label('Nama Barang'),
                
                Forms\Components\TextInput::make('jumlah_produksi')
                    ->numeric()
                    ->required()
                    ->label('Jumlah Produksi'),
                
                Forms\Components\TextInput::make('satuan')
                    ->default('pcs')
                    ->required()
                    ->label('Satuan'),
                
                Forms\Components\Textarea::make('catatan')
                    ->rows(3)
                    ->label('Catatan'),
            ]);
    }

    /**
     * Tabel untuk menampilkan data produksi barang
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_produksi')
                    ->sortable()
                    ->date()
                    ->label('Tanggal'),

                Tables\Columns\TextColumn::make('petani.nama') // sesuaikan dengan relasi
                    ->label('Nama Petani'),

                Tables\Columns\TextColumn::make('nama_barang')
                    ->label('Barang'),

                Tables\Columns\TextColumn::make('jumlah_produksi')
                    ->label('Jumlah'),

                Tables\Columns\TextColumn::make('satuan')
                    ->label('Satuan'),
            ])
            ->filters([
                // Tambahkan filter di sini jika diperlukan
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

    /**
     * Relasi tambahan untuk model ini
     */
    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi lainnya jika diperlukan
        ];
    }

    /**
     * Menentukan halaman untuk resource ini
     */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKelolaProduksiBarangs::route('/'),
            'create' => Pages\CreateKelolaProduksiBarang::route('/create'),
            'edit'   => Pages\EditKelolaProduksiBarang::route('/{record}/edit'),
        ];
    }
}
