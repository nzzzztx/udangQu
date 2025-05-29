<?php

namespace App\Filament\Resources\AbsensiResource\Pages;

use App\Filament\Resources\AbsensiResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListAbsensis extends ListRecords
{
    protected static string $resource = AbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('scan')
                ->label('Scan')
                ->icon('heroicon-o-qr-code')
                ->modalHeading('Scan QR Code')
                ->modalSubmitAction(false)
                ->modalContent(view('filament.modals.content.qr-code-scan'))
                ->modalWidth('md')
                ->color('success'),
        ];
    }
}