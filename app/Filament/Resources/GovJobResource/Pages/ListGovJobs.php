<?php
namespace App\Filament\Resources\GovJobResource\Pages;
// Save as: app/Filament/Resources/GovJobResource/Pages/ListGovJobs.php
use App\Filament\Resources\GovJobResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
class ListGovJobs extends ListRecords {
    protected static string $resource = GovJobResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
    public function getTabs(): array {
        return [
            'all'      => Tab::make('All Jobs'),
            'active'   => Tab::make('Active')->modifyQueryUsing(fn (Builder $q) => $q->where('status','active')->where('is_published',true))->badge(\App\Models\GovJob::where('status','active')->where('is_published',true)->count())->badgeColor('success'),
            'upcoming' => Tab::make('Upcoming')->modifyQueryUsing(fn (Builder $q) => $q->where('status','upcoming'))->badge(\App\Models\GovJob::where('status','upcoming')->count())->badgeColor('warning'),
            'expired'  => Tab::make('Expired')->modifyQueryUsing(fn (Builder $q) => $q->where('status','expired'))->badgeColor('danger'),
            'draft'    => Tab::make('Unpublished')->modifyQueryUsing(fn (Builder $q) => $q->where('is_published',false))->badgeColor('gray'),
        ];
    }
}
