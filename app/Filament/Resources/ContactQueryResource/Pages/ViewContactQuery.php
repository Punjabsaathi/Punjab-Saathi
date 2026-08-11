<?php

namespace App\Filament\Resources\ContactQueryResource\Pages;

use App\Filament\Resources\ContactQueryResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewContactQuery extends ViewRecord
{
    protected static string $resource = ContactQueryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}