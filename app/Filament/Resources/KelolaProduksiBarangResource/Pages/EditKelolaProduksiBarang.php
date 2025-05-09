<?php

namespace App\Filament\Resources\KelolaProduksiBarangResource\Pages;

use App\Filament\Resources\KelolaProduksiBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKelolaProduksiBarang extends EditRecord
{
    protected static string $resource = KelolaProduksiBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
