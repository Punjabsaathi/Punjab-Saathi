<?php
namespace App\Filament\Resources\GovJobCategoryResource\Pages;
// Save as: app/Filament/Resources/GovJobCategoryResource/Pages/ListGovJobCategories.php
use App\Filament\Resources\GovJobCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListGovJobCategories extends ListRecords {
    protected static string $resource = GovJobCategoryResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
