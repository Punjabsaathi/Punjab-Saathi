<?php
namespace App\Filament\Resources\GovUpdateCategoryResource\Pages;
use App\Filament\Resources\GovUpdateCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListGovUpdateCategories extends ListRecords {
    protected static string $resource = GovUpdateCategoryResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
