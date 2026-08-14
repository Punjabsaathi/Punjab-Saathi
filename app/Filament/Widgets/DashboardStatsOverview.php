<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\ContactQuery;
use App\Models\Inquiry;
use App\Models\Service;
use App\Models\ServiceApplication;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Contact Queries', ContactQuery::count())
                ->description(ContactQuery::where('status', 'new')->count() . ' new')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),

            Stat::make('Applications', ServiceApplication::count())
                ->description(ServiceApplication::where('status', 'pending')->count() . ' pending')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Inquiries', Inquiry::count())
                ->description(Inquiry::where('status', 'new')->count() . ' new')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('warning'),

            Stat::make('Published Blogs', Blog::where('status', 'published')->count())
                ->description(Blog::count() . ' total')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),

            Stat::make('Active Services', Service::where('is_active', true)->count())
                ->description(Service::count() . ' total')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success'),
        ];
    }
}
