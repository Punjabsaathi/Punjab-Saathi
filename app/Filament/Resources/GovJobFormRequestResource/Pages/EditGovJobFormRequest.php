<?php
namespace App\Filament\Resources\GovJobFormRequestResource\Pages;
// Save as: app/Filament/Resources/GovJobFormRequestResource/Pages/EditGovJobFormRequest.php
use App\Filament\Resources\GovJobFormRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditGovJobFormRequest extends EditRecord {
    protected static string $resource = GovJobFormRequestResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}
