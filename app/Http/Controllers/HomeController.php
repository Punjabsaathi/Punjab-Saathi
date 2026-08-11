<?php
namespace App\Http\Controllers;
use App\Models\Service;
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

        return view('pages.home', compact('serviceCategories'));
    }
    public function about()   { return view('pages.about'); }
    public function services(){ return view('pages.services'); }
    public function projects(){ return view('pages.projects'); }
    public function blog()    { return view('pages.blog'); }
    public function contact() { return view('pages.contact'); }
}