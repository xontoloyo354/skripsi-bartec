<?php

namespace App\Filament\Resources\GolonganResource\Pages;

use App\Filament\Resources\GolonganResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGolongan extends ViewRecord
{
    protected static string $resource = GolonganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
