<?php
namespace App\Filament\Resources\GovJobResource\Pages;
// Save as: app/Filament/Resources/GovJobResource/Pages/EditGovJob.php
use App\Filament\Resources\GovJobResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditGovJob extends EditRecord {
    protected static string $resource = GovJobResource::class;
    protected function getHeaderActions(): array {
        return [
            Actions\Action::make('view')
                ->label('View on Website')
                ->icon('heroicon-o-eye')
                ->url(fn () => url('/jobs/' . $this->record->slug))
                ->openUrlInNewTab(),
            Actions\Action::make('togglePublish')
                ->label(fn () => $this->record->is_published ? 'Unpublish' : 'Publish')
                ->icon(fn () => $this->record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                ->color(fn () => $this->record->is_published ? 'warning' : 'success')
                ->action(function () {
                    $this->record->update(['is_published' => !$this->record->is_published]);
                    \Filament\Notifications\Notification::make()
                        ->title($this->record->is_published ? 'Job Published' : 'Job Unpublished')
                        ->success()->send();
                }),
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array {
        // Convert simple arrays back to repeater format
        if (isset($data['selection_process']) && is_array($data['selection_process'])) {
            $data['selection_process'] = array_map(fn ($s) => ['step' => $s], $data['selection_process']);
        }
        if (isset($data['application_steps']) && is_array($data['application_steps'])) {
            $data['application_steps'] = array_map(fn ($s) => ['step' => $s], $data['application_steps']);
        }
        if (isset($data['required_documents']) && is_array($data['required_documents'])) {
            $data['required_documents'] = array_map(fn ($s) => ['document' => $s], $data['required_documents']);
        }
        return $data;
    }
    protected function mutateFormDataBeforeSave(array $data): array {
        if (isset($data['selection_process']) && is_array($data['selection_process'])) {
            $data['selection_process'] = array_column($data['selection_process'], 'step');
        }
        if (isset($data['application_steps']) && is_array($data['application_steps'])) {
            $data['application_steps'] = array_column($data['application_steps'], 'step');
        }
        if (isset($data['required_documents']) && is_array($data['required_documents'])) {
            $data['required_documents'] = array_column($data['required_documents'], 'document');
        }
        return $data;
    }
}
