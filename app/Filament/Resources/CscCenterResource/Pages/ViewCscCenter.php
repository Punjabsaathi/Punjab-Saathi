<?php

namespace App\Filament\Resources\CscCenterResource\Pages;

use App\Filament\Resources\CscCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCscCenter extends ViewRecord
{
    protected static string $resource = CscCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
