<?php

namespace App\Filament\Resources\ServiceFaqResource\Pages;

use App\Filament\Resources\ServiceFaqResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceFaq extends EditRecord
{
    protected static string $resource = ServiceFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}