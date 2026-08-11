<?php

namespace App\Http\Controllers;

use App\Models\FormCategory;
use App\Models\GovForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $categorySlug = $request->get('category');

        $results = collect();
        $total   = 0;

        if (strlen(trim($query)) >= 2) {
            $q = GovForm::active()->with(['category']);

            $q->where(function ($sq) use ($query) {
                $sq->where('title', 'like', "%{$query}%")
                   ->orWhere('short_description', 'like', "%{$query}%")
                   ->orWhere('meta_keywords', 'like', "%{$query}%")
                   ->orWhereHas('tags', fn ($t) => $t->where('name', 'like', "%{$query}%"));
            });

            if ($categorySlug) {
                $cat = FormCategory::where('slug', $categorySlug)->first();
                if ($cat) {
                    $q->where('category_id', $cat->id);
                }
            }

            $results = $q->orderByDesc('download_count')->paginate(18)->withQueryString();
            $total   = $results->total();
        }

        $categories = Cache::remember('nav_categories', 3600, fn () =>
            FormCategory::with('children')->whereNull('parent_id')->active()->orderBy('sort_order')->get()
        );

        return view('search.index', compact('results', 'query', 'total', 'categories'));
    }

    /** JSON endpoint for search autocomplete */
    public function autocomplete(Request $request)
    {
        $q = $request->get('q', '');
        if (strlen($q) < 2) return response()->json([]);

        $results = GovForm::active()
            ->where('title', 'like', "%{$q}%")
            ->select('title', 'slug', 'category_id')
            ->with('category:id,name')
            ->take(8)
            ->get()
            ->map(fn ($f) => [
                'title'    => $f->title,
                'url'      => route('forms.show', $f->slug),
                'category' => $f->category->name ?? '',
            ]);

        return response()->json($results);
    }
}
