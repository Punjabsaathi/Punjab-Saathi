<?php
namespace App\Filament\Resources\GovJobResource\Pages;
// Save as: app/Filament/Resources/GovJobResource/Pages/CreateGovJob.php
use App\Filament\Resources\GovJobResource;
use Filament\Resources\Pages\CreateRecord;
class CreateGovJob extends CreateRecord {
    protected static string $resource = GovJobResource::class;
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]); }
    protected function mutateFormDataBeforeCreate(array $data): array {
        // Flatten repeater arrays to simple arrays
        if (isset($data['selection_process'])) {
            $data['selection_process'] = array_column($data['selection_process'], 'step');
        }
        if (isset($data['application_steps'])) {
            $data['application_steps'] = array_column($data['application_steps'], 'step');
        }
        if (isset($data['required_documents'])) {
            $data['required_documents'] = array_column($data['required_documents'], 'document');
        }
        return $data;
    }
}
