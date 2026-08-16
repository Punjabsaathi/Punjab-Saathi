<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Image upload now lives inline on the "Image" tab of the form
            // itself (see ServiceResource::form()) — no separate button needed.
            Actions\DeleteAction::make(),
        ];
    }
}
