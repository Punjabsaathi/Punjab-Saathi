<?php

namespace App\Providers;
use App\Models\ContactQuery;
use App\Models\GovJobFormRequest;
use App\Models\Inquiry;
use App\Models\Service;
use App\Models\ServiceApplication;
use App\Observers\StatusChangeObserver;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         View::composer('*', function ($view) {
        $view->with('megaServices', Service::orderBy('category')->orderBy('title')->get()->groupBy('category'));
    });

        ContactQuery::observe(StatusChangeObserver::class);
        Inquiry::observe(StatusChangeObserver::class);
        GovJobFormRequest::observe(StatusChangeObserver::class);
        ServiceApplication::observe(StatusChangeObserver::class);
    }
}
