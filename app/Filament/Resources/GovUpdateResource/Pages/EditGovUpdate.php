<?php
namespace App\Filament\Resources\GovUpdateResource\Pages;
use App\Filament\Resources\GovUpdateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditGovUpdate extends EditRecord {
    protected static string $resource = GovUpdateResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}
