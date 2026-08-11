<?php

namespace App\Http\Controllers;

use App\Models\FormCategory;
use App\Models\FormDownloadLog;
use App\Models\GovForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    public function index(Request $request)
    {
        $query = GovForm::with(['category', 'tags'])->active();

        if ($request->filled('category')) {
            $category = FormCategory::where('slug', $request->category)->firstOrFail();
            $query->where(function ($q) use ($category) {
                $q->where('category_id', $category->id)
                  ->orWhere('subcategory_id', $category->id);
            });
        }

        if ($request->filled('q')) {
            $query->search($request->q);
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'popular'   => $query->orderByDesc('download_count'),
            'az'        => $query->orderBy('title'),
            default     => $query->orderByDesc('published_date'),
        };

        $forms      = $query->paginate(18)->withQueryString();
        $categories = $this->cachedCategories();
        $featured   = $this->cachedFeatured();
        $popular    = $this->cachedPopular();

        return view('pages.forms.index', compact('forms', 'categories', 'featured', 'popular'));
    }

    public function show(string $slug)
    {
        $form = GovForm::with(['category', 'subcategory', 'tags', 'faqs', 'relatedForms'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $categories = $this->cachedCategories();
        $related    = $form->relatedForms()->active()->take(6)->get();

        if ($related->isEmpty()) {
            $related = GovForm::active()
                ->where('category_id', $form->category_id)
                ->where('id', '!=', $form->id)
                ->inRandomOrder()
                ->take(6)
                ->get();
        }

        $schemaMarkup = $this->buildSchemaMarkup($form);

        return view('pages.forms.show', compact('form', 'categories', 'related', 'schemaMarkup'));
    }

    public function download(Request $request, string $slug)
    {
        $form = GovForm::where('slug', $slug)->active()->firstOrFail();

        // Log the download
        FormDownloadLog::create([
            'gov_form_id'  => $form->id,
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
            'referer'      => $request->headers->get('referer'),
            'downloaded_at' => now(),
        ]);

        // Increment counter (queued for performance)
        $form->increment('download_count');

        if (!Storage::exists($form->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::download(
            $form->file_path,
            $form->file_name ?: ($form->slug . '.pdf'),
            ['Content-Type' => $form->file_mime]
        );
    }

    // ── Cached helpers ────────────────────────────────────────────────────

    private function cachedCategories()
    {
        return Cache::remember('nav_categories', 3600, function () {
            return FormCategory::with('children')
                ->whereNull('parent_id')
                ->active()
                ->orderBy('sort_order')
                ->get();
        });
    }

    private function cachedFeatured(int $limit = 6)
    {
        return Cache::remember('featured_forms', 1800, function () use ($limit) {
            return GovForm::featured()->with('category')->orderByDesc('published_date')->take($limit)->get();
        });
    }

    private function cachedPopular(int $limit = 6)
    {
        return Cache::remember('popular_forms', 1800, function () use ($limit) {
            return GovForm::popular()->with('category')->orderByDesc('download_count')->take($limit)->get();
        });
    }

    // ── Schema.org structured data ────────────────────────────────────────

    private function buildSchemaMarkup(GovForm $form): string
    {
        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'DigitalDocument',
            'name'        => $form->title,
            'description' => $form->short_description,
            'url'         => route('forms.show', $form->slug),
            'datePublished' => optional($form->published_date)->toDateString(),
            'dateModified'  => $form->updated_at->toDateString(),
            'inLanguage'    => 'en-IN',
            'about'         => [
                '@type' => 'GovernmentService',
                'name'  => $form->category->name,
            ],
            'publisher' => [
                '@type' => 'GovernmentOrganization',
                'name'  => 'Punjab Seva Kendra',
                'url'   => config('app.url'),
            ],
        ];

        if ($form->faqs->isNotEmpty()) {
            $schema['mainEntity'] = [
                '@type'            => 'FAQPage',
                'mainEntity'       => $form->faqs->map(fn ($faq) => [
                    '@type'          => 'Question',
                    'name'           => $faq->question,
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq->answer],
                ])->toArray(),
            ];
        }

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
