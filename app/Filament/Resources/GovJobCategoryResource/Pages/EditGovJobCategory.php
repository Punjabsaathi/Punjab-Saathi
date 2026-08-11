<?php
namespace App\Filament\Resources\GovJobCategoryResource\Pages;
// Save as: app/Filament/Resources/GovJobCategoryResource/Pages/EditGovJobCategory.php
use App\Filament\Resources\GovJobCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditGovJobCategory extends EditRecord {
    protected static string $resource = GovJobCategoryResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}
