<?php

namespace App\Filament\Resources\CscCenterResource\Pages;

use App\Filament\Resources\CscCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCscCenter extends EditRecord
{
    protected static string $resource = CscCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
