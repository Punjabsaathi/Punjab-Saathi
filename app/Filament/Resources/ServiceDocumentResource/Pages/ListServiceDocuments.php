<?php

namespace App\Filament\Resources\ServiceDocumentResource\Pages;

use App\Filament\Resources\ServiceDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceDocuments extends ListRecords
{
    protected static string $resource = ServiceDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
