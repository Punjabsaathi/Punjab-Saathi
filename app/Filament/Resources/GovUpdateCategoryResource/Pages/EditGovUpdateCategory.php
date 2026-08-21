<?php
namespace App\Filament\Resources\GovUpdateCategoryResource\Pages;
use App\Filament\Resources\GovUpdateCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditGovUpdateCategory extends EditRecord {
    protected static string $resource = GovUpdateCategoryResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}
