<?php
namespace App\Filament\Resources\GovUpdateCategoryResource\Pages;
use App\Filament\Resources\GovUpdateCategoryResource;
use Filament\Resources\Pages\CreateRecord;
class CreateGovUpdateCategory extends CreateRecord {
    protected static string $resource = GovUpdateCategoryResource::class;
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}
