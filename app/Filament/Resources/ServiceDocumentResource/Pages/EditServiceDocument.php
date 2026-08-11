<?php

namespace App\Filament\Resources\ServiceDocumentResource\Pages;

use App\Filament\Resources\ServiceDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceDocument extends EditRecord
{
    protected static string $resource = ServiceDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
