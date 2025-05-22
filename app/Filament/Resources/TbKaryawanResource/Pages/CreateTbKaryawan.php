<?php

namespace App\Filament\Resources\TbKaryawanResource\Pages;

use App\Filament\Resources\TbKaryawanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;


class CreateTbKaryawan extends CreateRecord
{
    protected static string $resource = TbKaryawanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['qr_code'] = Str::random(12); // generate 12 karakter acak
        return $data;
    }
}

