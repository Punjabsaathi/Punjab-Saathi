<?php
namespace App\Filament\Resources\GovJobFormRequestResource\Pages;
// Save as: app/Filament/Resources/GovJobFormRequestResource/Pages/ListGovJobFormRequests.php
use App\Filament\Resources\GovJobFormRequestResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
class ListGovJobFormRequests extends ListRecords {
    protected static string $resource = GovJobFormRequestResource::class;
    public function getTabs(): array {
        return [
            'all'       => Tab::make('All'),
            'pending'   => Tab::make('Pending')->modifyQueryUsing(fn (Builder $q) => $q->where('status','pending'))->badge(\App\Models\GovJobFormRequest::where('status','pending')->count())->badgeColor('danger'),
            'contacted' => Tab::make('Contacted')->modifyQueryUsing(fn (Builder $q) => $q->where('status','contacted'))->badgeColor('warning'),
            'completed' => Tab::make('Completed')->modifyQueryUsing(fn (Builder $q) => $q->where('status','completed'))->badgeColor('success'),
        ];
    }
}
