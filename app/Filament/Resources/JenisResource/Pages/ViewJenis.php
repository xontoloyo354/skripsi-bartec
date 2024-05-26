<?php

namespace App\Filament\Resources\JenisResource\Pages;

use App\Filament\Resources\JenisResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJenis extends ViewRecord
{
    protected static string $resource = JenisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
