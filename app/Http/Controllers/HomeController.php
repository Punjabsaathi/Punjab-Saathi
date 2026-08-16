<?php
namespace App\Http\Controllers;
use App\Models\GoogleReview;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\View\View;

class HomeController extends Controller
{
    // public function index()   { return view('pages.home'); }
    public function index(): View
    {
        // Group active services by category, same as ServiceController
        $serviceCategories = Service::active()
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        // Backend-managed category display data (label, image, etc.) —
        // keyed by slug so blade can look up e.g. $categoryDisplay['identity']
        $categoryDisplay = ServiceCategory::active()
            ->orderBy('sort_order')
            ->get()
            ->keyBy('slug');

        // Popular services for the homepage "Popular Services" section —
        // top up with other active services if fewer than 6 are marked
        // popular, so the section never looks sparse.
        $popularServices = Service::popular()->active()->orderBy('sort_order')->take(6)->get();
        if ($popularServices->count() < 6) {
            $popularServices = $popularServices
                ->concat(
                    Service::active()
                        ->whereNotIn('id', $popularServices->pluck('id'))
                        ->orderBy('sort_order')
                        ->take(6 - $popularServices->count())
                        ->get()
                );
        }

        $googleReviews = GoogleReview::active()->orderBy('sort_order')->get();
        $reviewAvgRating = $googleReviews->isNotEmpty() ? round($googleReviews->avg('rating'), 1) : null;

        return view('pages.home', compact(
            'serviceCategories', 'popularServices', 'categoryDisplay', 'googleReviews', 'reviewAvgRating'
        ));
    }
    public function about()   { return view('pages.about'); }
    public function services(){ return view('pages.services'); }
    public function projects(){ return view('pages.projects'); }
    public function blog()    { return view('pages.blog'); }
    public function contact() { return view('pages.contact'); }
}