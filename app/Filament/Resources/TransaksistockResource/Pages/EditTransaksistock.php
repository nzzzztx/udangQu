<?php

namespace App\Filament\Resources\TransaksistockResource\Pages;

use App\Filament\Resources\TransaksistockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransaksistock extends EditRecord
{
    protected static string $resource = TransaksistockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
