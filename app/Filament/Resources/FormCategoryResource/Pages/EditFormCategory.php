<?php

namespace App\Filament\Resources\FormCategoryResource\Pages;

use App\Filament\Resources\FormCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormCategory extends EditRecord
{
    protected static string $resource = FormCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
