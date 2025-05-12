<?php

namespace App\Filament\Resources\TbKaryawanResource\Pages;

use App\Filament\Resources\TbKaryawanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;


class EditTbKaryawan extends EditRecord
{
    protected static string $resource = TbKaryawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }
}
