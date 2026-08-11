<?php

namespace App\Filament\Resources\ContactQueryResource\Pages;

use App\Filament\Resources\ContactQueryResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditContactQuery extends EditRecord
{
    protected static string $resource = ContactQueryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}