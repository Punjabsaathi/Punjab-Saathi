<?php
namespace App\Filament\Resources\GovUpdateResource\Pages;
use App\Filament\Resources\GovUpdateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListGovUpdates extends ListRecords {
    protected static string $resource = GovUpdateResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
