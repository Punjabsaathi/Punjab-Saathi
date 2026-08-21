<?php

namespace App\Http\Controllers;

use App\Models\GovUpdate;
use App\Models\GovUpdateCategory;
use Illuminate\Http\Request;

class GovUpdateController extends Controller
{
    private const HUB_TITLE = 'Government Updates — Latest News & Announcements';
    private const HUB_DESC  = 'Latest government-related updates on Aadhaar, PAN, Passport, Voter ID, Driving Licence, certificates, fees, and procedures — explained clearly, in one place, by Punjab Saathi.';

    public function index(Request $request)
    {
        $query = GovUpdate::published()->with('category')->latest('published_at');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn ($s) => $s->where('title', 'like', "%$q%")->orWhere('short_description', 'like', "%$q%"));
        }

        $updates    = $query->paginate(12)->withQueryString();
        $categories = GovUpdateCategory::where('is_active', true)
            ->withCount(['updates' => fn ($q) => $q->published()])
            ->orderBy('sort_order')->get();
        $important  = GovUpdate::published()->important()->latest('published_at')->take(5)->get();

        [$metaTitle, $metaDesc, $canonical, $robotsMeta, $breadcrumbSchema, $itemListSchema] =
            $this->buildListingSeo($request, $updates, self::HUB_TITLE . ' ' . now()->year . ' | Punjab Saathi', self::HUB_DESC, route('gov-updates.index'), 'Government Updates');

        return view('gov-updates.index', compact(
            'updates', 'categories', 'important',
            'metaTitle', 'metaDesc', 'canonical', 'robotsMeta', 'breadcrumbSchema', 'itemListSchema'
        ));
    }

    public function category(Request $request, string $slug)
    {
        $category = GovUpdateCategory::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $query = GovUpdate::published()->where('category_id', $category->id)->with('category')->latest('published_at');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn ($s) => $s->where('title', 'like', "%$q%")->orWhere('short_description', 'like', "%$q%"));
        }

        $updates    = $query->paginate(12)->withQueryString();
        $categories = GovUpdateCategory::where('is_active', true)
            ->withCount(['updates' => fn ($q) => $q->published()])
            ->orderBy('sort_order')->get();
        $important  = GovUpdate::published()->important()->latest('published_at')->take(5)->get();

        [$metaTitle, $metaDesc, $canonical, $robotsMeta, $breadcrumbSchema, $itemListSchema] =
            $this->buildListingSeo($request, $updates, $category->seo_title, $category->seo_description, $category->canonical_url, $category->name, $category->toBreadcrumbSchema());

        return view('gov-updates.index', compact(
            'updates', 'categories', 'important', 'category',
            'metaTitle', 'metaDesc', 'canonical', 'robotsMeta', 'breadcrumbSchema', 'itemListSchema'
        ));
    }

    private function buildListingSeo(Request $request, $updates, string $metaTitle, string $metaDesc, string $baseUrl, string $breadcrumbLabel, ?array $breadcrumbOverride = null): array
    {
        $hasFilters = $request->hasAny(['search']);
        $page       = max(1, (int) $request->query('page', 1));

        $canonical  = $hasFilters ? $baseUrl : ($page > 1 ? $baseUrl . '?page=' . $page : $baseUrl);
        $robotsMeta = $hasFilters ? 'noindex,follow' : 'index,follow';

        $breadcrumbSchema = $breadcrumbOverride ?? [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $breadcrumbLabel, 'item' => $baseUrl],
            ],
        ];

        $itemListSchema = null;
        if (! $hasFilters && count($updates->items())) {
            $offset = ($updates->currentPage() - 1) * $updates->perPage();
            $itemListSchema = [
                '@context' => 'https://schema.org',
                '@type'    => 'ItemList',
                'itemListElement' => collect($updates->items())->values()->map(fn ($u, $i) => [
                    '@type'    => 'ListItem',
                    'position' => $offset + $i + 1,
                    'url'      => route('gov-updates.show', $u->slug),
                    'name'     => $u->title,
                ])->all(),
            ];
        }

        return [$metaTitle, $metaDesc, $canonical, $robotsMeta, $breadcrumbSchema, $itemListSchema];
    }

    public function show(string $slug)
    {
        $update = GovUpdate::published()
            ->with(['category', 'relatedService'])
            ->where('slug', $slug)
            ->firstOrFail();

        $update->incrementViews();

        $related = GovUpdate::published()
            ->where('id', '!=', $update->id)
            ->where('category_id', $update->category_id)
            ->latest('published_at')
            ->take(4)
            ->get();

        $categories = GovUpdateCategory::where('is_active', true)
            ->withCount(['updates' => fn ($q) => $q->published()])
            ->orderBy('sort_order')->get();

        $metaTitle        = $update->seo_title;
        $metaDesc         = $update->seo_description;
        $articleSchema    = $update->toArticleSchema();
        $breadcrumbSchema = $update->toBreadcrumbSchema();

        return view('gov-updates.show', compact(
            'update', 'related', 'categories', 'metaTitle', 'metaDesc', 'articleSchema', 'breadcrumbSchema'
        ));
    }
}
