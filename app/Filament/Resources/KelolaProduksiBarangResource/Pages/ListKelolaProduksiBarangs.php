<?php

namespace App\Filament\Resources\KelolaProduksiBarangResource\Pages;

use App\Filament\Resources\KelolaProduksiBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKelolaProduksiBarangs extends ListRecords
{
    protected static string $resource = KelolaProduksiBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
