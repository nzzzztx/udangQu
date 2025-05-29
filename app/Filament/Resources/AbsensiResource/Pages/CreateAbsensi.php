<?php

namespace App\Filament\Resources\AbsensiResource\Pages;

use App\Filament\Resources\AbsensiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use App\Models\Absensi;

class CreateAbsensi extends CreateRecord
{
    protected static string $resource = AbsensiResource::class;

    protected function beforeCreate(): void
    {
        $data = $this->form->getState();

        $exists = Absensi::where('karyawan_id', $data['karyawan_id'])
            ->whereDate('tanggal_absensi', $data['tanggal_absensi'])
            ->exists();

        if ($exists) {
            Notification::make()
                ->title('Karyawan sudah melakukan absen.')
                ->danger()
                ->send();

            $this->halt();
        }
    }

}