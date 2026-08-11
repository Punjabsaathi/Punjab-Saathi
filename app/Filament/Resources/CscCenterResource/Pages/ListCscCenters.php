<?php

namespace App\Filament\Resources\CscCenterResource\Pages;

use App\Filament\Resources\CscCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCscCenters extends ListRecords
{
    protected static string $resource = CscCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
