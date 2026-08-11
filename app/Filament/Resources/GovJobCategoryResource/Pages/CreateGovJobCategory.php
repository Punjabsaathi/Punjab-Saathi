<?php
namespace App\Filament\Resources\GovJobCategoryResource\Pages;
// Save as: app/Filament/Resources/GovJobCategoryResource/Pages/CreateGovJobCategory.php
use App\Filament\Resources\GovJobCategoryResource;
use Filament\Resources\Pages\CreateRecord;
class CreateGovJobCategory extends CreateRecord {
    protected static string $resource = GovJobCategoryResource::class;
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}
