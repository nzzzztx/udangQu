<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksistockResource\Pages;
use App\Filament\Resources\TransaksistockResource\RelationManagers;
use App\Models\Transaksistock;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms;
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

                Select::make('barang_id')
                    ->required()
                    ->relationship('tb_barang', 'nama_barang')
                    ->searchable()
                    ->reactive()
                    ->label('Nama Barang')
                    ->placeholder('Masukan nama barang')
                    ->relationship(
                        name: 'tb_barang',
                        titleAttribute: 'nama_barang',
                    )
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $barang = \App\Models\barangstock::find($state);
                            if ($barang) {
                                $set('jumlah_stock', $barang->jumlah_stock);
                                $set('harga_barang', $barang->harga_barang);
                                $set('satuan_barang', $barang->satuan);

                                // Hitung sisa_stock otomatis
                                $lastTransaksi = \App\Models\TransaksiStock::where('barang_id', $state)
                                    ->orderByDesc('tanggal_transaksi')
                                    ->first();

                                if ($lastTransaksi) {
                                    // Bandingkan tanggal stock barang dan transaksi
                                    if ($barang->tanggal_stock > $lastTransaksi->tanggal_transaksi) {
                                        // Barang di-restock, pakai jumlah_stock terbaru
                                        $sisaStock = $barang->jumlah_stock;
                                    } else {
                                        // Pakai sisa dari transaksi terakhir
                                        $sisaStock = $lastTransaksi->sisa_stock;
                                    }
                                } else {
                                    // Tidak ada transaksi sama sekali, pakai dari tb_barang
                                    $sisaStock = $barang->jumlah_stock;
                                }

                                $set('sisa_stock', $sisaStock);
                            }
                        }
                    })
                    ,

                Forms\Components\TextInput::make('jumlah_barang')
                    ->label('Jumlah Barang')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(0)
                    ->placeholder('Masukan jumlah barang')
                    ->suffix(fn (callable $get) => $get('satuan_barang') ?? '')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $sisaAwal = $get('sisa_stock');
                        $jumlah = $state;
                        $set('sisa_stock', $sisaAwal - $jumlah);
                    })
                    ,

                TextArea::make('catatan')
                    ->label('Catatan')
                    ->placeholder('Masukan keterangan barang'),

                Forms\Components\TextInput::make('jumlah_stock')
                    ->label('Jumlah Stock')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(1)
                    ->readonly()
                    ->placeholder('Masukan jumlah stock')
                    ->suffix(fn (callable $get) => $get('satuan_barang') ?? ''),

                Forms\Components\TextInput::make('sisa_stock')
                    ->label('Sisa Stock')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(1)
                    ->readonly()
                    ->placeholder('Masukan sisa stock')
                    ->suffix(fn (callable $get) => $get('satuan_barang') ?? ''),

                Forms\Components\TextInput::make('harga_barang')
                    ->label('harga barang')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->prefix('Rp')
                    ->default(0)
                    ->readonly()
                    ->placeholder('Masukan harga barang'),

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
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        return $state . ' /' . ($record->tb_barang?->satuan ?? '');
                    }),

                Tables\Columns\TextColumn::make('harga_barang')
                    ->label('Harga Barang')
                    ->sortable()
                    ->money('IDR', true)
                    ->prefix('Rp')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.')),

                Tables\Columns\TextColumn::make('jumlah_stock')
                    ->label('Jumlah Stock')
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        return $state . ' /' . ($record->tb_barang?->satuan ?? '');
                    }),

                Tables\Columns\TextColumn::make('sisa_stock')
                    ->label('Sisa Stock')
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        return $state . ' /' . ($record->tb_barang?->satuan ?? '');
                    }),

                Tables\Columns\TextColumn::make('catatan')
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
