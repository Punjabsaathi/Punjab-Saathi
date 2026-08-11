<?php

namespace App\Http\Controllers;

use App\Models\FormCategory;
use App\Models\GovForm;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('all_categories_page', 3600, function () {
            return FormCategory::with(['children' => function ($q) {
                $q->active()->withCount(['forms' => fn ($q) => $q->active()]);
            }])
            ->whereNull('parent_id')
            ->active()
            ->withCount(['forms' => fn ($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();
        });

        $featured = GovForm::featured()->with('category')->take(6)->get();

        return view('pages.forms.categories.index', compact('categories', 'featured'));
    }

    public function show(string $slug)
    {
        $category = FormCategory::with(['children' => fn ($q) => $q->active()])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $query = GovForm::with(['category', 'tags'])
            ->active()
            ->where(function ($q) use ($category) {
                $q->where('category_id', $category->id)
                  ->orWhere('subcategory_id', $category->id)
                  ->orWhereIn('category_id', $category->children->pluck('id'));
            })
            ->orderByDesc('published_date');

        $forms = $query->paginate(18);

        $allCategories = Cache::remember('nav_categories', 3600, fn () =>
            FormCategory::with('children')->whereNull('parent_id')->active()->orderBy('sort_order')->get()
        );

        $popular = GovForm::popular()->with('category')
            ->where('category_id', $category->id)
            ->orderByDesc('download_count')
            ->take(5)->get();

        return view('pages.forms.categories.show', compact('category', 'forms', 'allCategories', 'popular'));
    }
}
