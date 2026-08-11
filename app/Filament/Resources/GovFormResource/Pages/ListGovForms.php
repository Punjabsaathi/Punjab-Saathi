<?php

namespace App\Filament\Resources\GovFormResource\Pages;

use App\Filament\Resources\GovFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGovForms extends ListRecords
{
    protected static string $resource = GovFormResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
