<?php

namespace App\Filament\Resources\TbKaryawanResource\Pages;

use App\Filament\Resources\TbKaryawanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTbKaryawans extends ListRecords
{
    protected static string $resource = TbKaryawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
