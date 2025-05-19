<?php

namespace App\Filament\Resources\TransaksistockResource\Pages;

use App\Filament\Resources\TransaksistockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransaksistocks extends ListRecords
{
    protected static string $resource = TransaksistockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
