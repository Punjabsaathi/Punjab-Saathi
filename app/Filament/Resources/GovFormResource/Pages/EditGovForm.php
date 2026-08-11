<?php

namespace App\Filament\Resources\GovFormResource\Pages;

use App\Filament\Resources\GovFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGovForm extends EditRecord
{
    protected static string $resource = GovFormResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
