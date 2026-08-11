<?php

namespace App\Filament\Resources\ServiceApplicationResource\Pages;

use App\Filament\Resources\ServiceApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceApplication extends ViewRecord
{
    protected static string $resource = ServiceApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}