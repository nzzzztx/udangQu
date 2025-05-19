<?php

namespace App\Filament\Resources\BarangstockResource\Pages;

use App\Filament\Resources\BarangstockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangstocks extends ListRecords
{
    protected static string $resource = BarangstockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
