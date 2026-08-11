<?php

namespace App\Filament\Resources\FormCategoryResource\Pages;

use App\Filament\Resources\FormCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormCategories extends ListRecords
{
    protected static string $resource = FormCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
