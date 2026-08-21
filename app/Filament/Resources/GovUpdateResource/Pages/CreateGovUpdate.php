<?php
namespace App\Filament\Resources\GovUpdateResource\Pages;
use App\Filament\Resources\GovUpdateResource;
use Filament\Resources\Pages\CreateRecord;
class CreateGovUpdate extends CreateRecord {
    protected static string $resource = GovUpdateResource::class;
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}
