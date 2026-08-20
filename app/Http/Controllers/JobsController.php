<?php

namespace App\Http\Controllers;

// ─────────────────────────────────────────────────────────
// Save as: app/Http/Controllers/JobsController.php
// ─────────────────────────────────────────────────────────

use Illuminate\Http\Request;
use App\Filament\Resources\GovJobFormRequestResource;
use App\Models\GovJob;
use App\Models\GovJobCategory;
use App\Models\GovJobAdmitCard;
use App\Models\GovJobResult;
use App\Models\GovJobAnswerKey;
use App\Models\GovJobFormRequest;
use App\Models\JobsPageSetting;
use App\Services\FormNotificationService;
use App\Support\FormSubmissionData;

class JobsController extends Controller
{
    // ── Main Jobs Listing ────────────────────────────────
    public function index(Request $request)
    {
        // The base index used to also accept ?category= as an alternate
        // way to reach a category, duplicating /jobs/category/{slug} at a
        // second indexable URL. Nothing in the UI ever links to it (only
        // the path-based route is used anywhere), so redirect it to the
        // canonical URL instead of rendering duplicate content.
        if ($request->filled('category')) {
            return redirect()->route('jobs.category', $request->category, 301);
        }

        $categories = GovJobCategory::where('is_active', true)
            ->withCount(['jobs', 'activeJobs'])
            ->orderBy('sort_order')
            ->get();

        $query = GovJob::published()
            ->with('category')
            ->punjabFirst()
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($s) => $s->where('title', 'like', "%$q%")->orWhere('department', 'like', "%$q%"));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobs = $query->paginate(15)->withQueryString();

        $stats = [
            'total'    => GovJob::published()->count(),
            'active'   => GovJob::published()->where('status', 'active')->count(),
            'upcoming' => GovJob::published()->where('status', 'upcoming')->count(),
        ];

        $recentJobs = GovJob::published()->punjabFirst()->latest()->limit(5)->get();

        $pageSettings = JobsPageSetting::current();

        [$metaTitle, $metaDesc, $canonical, $robotsMeta, $breadcrumbSchema, $itemListSchema, $faqSchema] =
            $this->buildListingSeo($request, $jobs, $pageSettings->seo_title, $pageSettings->meta_description, route('jobs.index'), 'Job Saathi', $pageSettings->toFaqSchema());

        return view('jobs.index', compact(
            'jobs', 'categories', 'stats', 'recentJobs', 'pageSettings',
            'metaTitle', 'metaDesc', 'canonical', 'robotsMeta',
            'breadcrumbSchema', 'itemListSchema', 'faqSchema'
        ));
    }

    // ── Jobs by Category ─────────────────────────────────
    public function category(Request $request, $slug)
    {
        $category = GovJobCategory::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $categories = GovJobCategory::where('is_active', true)
            ->withCount('jobs')->orderBy('sort_order')->get();

        $query = GovJob::published()
            ->where('category_id', $category->id)
            ->with('category')
            ->punjabFirst()
            ->orderByDesc('created_at');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($s) => $s->where('title', 'like', "%$q%")->orWhere('department', 'like', "%$q%"));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobs = $query->paginate(15)->withQueryString();

        $stats = [
            'total'    => GovJob::published()->count(),
            'active'   => GovJob::published()->where('status', 'active')->count(),
            'upcoming' => GovJob::published()->where('status', 'upcoming')->count(),
        ];

        $recentJobs = GovJob::published()->punjabFirst()->latest()->limit(5)->get();

        [$metaTitle, $metaDesc, $canonical, $robotsMeta, $breadcrumbSchema, $itemListSchema, $faqSchema] =
            $this->buildListingSeo($request, $jobs, $category->seo_title, $category->seo_description, $category->canonical_url, $category->name, null, $category->toBreadcrumbSchema());

        return view('jobs.index', compact(
            'jobs', 'categories', 'stats', 'recentJobs', 'category',
            'metaTitle', 'metaDesc', 'canonical', 'robotsMeta',
            'breadcrumbSchema', 'itemListSchema', 'faqSchema'
        ));
    }

    // ── Shared SEO builder for the hub + category listing views ──
    // Both render jobs.index and need the same canonical/robots/schema
    // treatment for search & status filters (thin/duplicate query states)
    // and the same pagination-aware ItemList of the current page's jobs.
    private function buildListingSeo(Request $request, $jobs, string $metaTitle, string $metaDesc, string $baseUrl, string $breadcrumbLabel, ?array $faqSchema = null, ?array $breadcrumbSchemaOverride = null): array
    {
        $hasFilters = $request->hasAny(['search', 'status']);
        $page       = max(1, (int) $request->query('page', 1));

        $canonical  = $hasFilters
            ? $baseUrl
            : ($page > 1 ? $baseUrl . '?page=' . $page : $baseUrl);

        $robotsMeta = $hasFilters ? 'noindex,follow' : 'index,follow';

        $breadcrumbSchema = $breadcrumbSchemaOverride ?? [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $breadcrumbLabel, 'item' => $baseUrl],
            ],
        ];

        // Only the current page's items — never the full dataset — and
        // only when this is a plain, indexable listing state.
        $itemListSchema = null;
        if (! $hasFilters && count($jobs->items())) {
            $offset = ($jobs->currentPage() - 1) * $jobs->perPage();
            $itemListSchema = [
                '@context' => 'https://schema.org',
                '@type'    => 'ItemList',
                'itemListElement' => collect($jobs->items())->values()->map(fn ($job, $i) => [
                    '@type'    => 'ListItem',
                    'position' => $offset + $i + 1,
                    'url'      => route('jobs.show', $job->slug),
                    'name'     => $job->title,
                ])->all(),
            ];
        }

        return [$metaTitle, $metaDesc, $canonical, $robotsMeta, $breadcrumbSchema, $itemListSchema, $hasFilters ? null : $faqSchema];
    }

    // ── Single Job Detail ────────────────────────────────
    public function show($slug)
    {
        $job = GovJob::published()
            ->where('slug', $slug)
            ->with([
                'category',
                'admitCards',
                'answerKeys',
                'results',
                'documents',
                'faqs',
                'updates',
            ])
            ->firstOrFail();

        // Increment views
        $job->increment('views');

        // Related jobs in same category
        $relatedJobs = GovJob::published()
            ->where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->limit(5)
            ->get();

        $categories = GovJobCategory::where('is_active', true)
            ->withCount('jobs')->orderBy('sort_order')->get();

        // SEO
        $metaTitle = $job->meta_title ?: $job->title . ' | Punjab Saathi';
        $metaDesc  = $job->meta_description ?: $job->short_description;

        $jobPostingSchema = $job->toJobPostingSchema();
        $breadcrumbSchema = $job->toBreadcrumbSchema();
        $faqSchema        = $job->toFaqSchema();

        return view('jobs.show', compact(
            'job', 'relatedJobs', 'categories', 'metaTitle', 'metaDesc',
            'jobPostingSchema', 'breadcrumbSchema', 'faqSchema'
        ));
    }

    // ── Admit Cards Listing ──────────────────────────────
    public function admitCards(Request $request)
    {
        $cards = GovJobAdmitCard::where('is_published', true)
            ->with('job.category')
            ->orderByDesc('created_at')
            ->paginate(20);

        $categories  = GovJobCategory::where('is_active', true)->withCount('jobs')->orderBy('sort_order')->get();
        $recentJobs  = GovJob::published()->punjabFirst()->latest()->limit(5)->get();

        return view('jobs.admit-cards', compact('cards', 'categories', 'recentJobs'));
    }

    // ── Results Listing ──────────────────────────────────
    public function results(Request $request)
    {
        $results = GovJobResult::where('is_published', true)
            ->with('job.category')
            ->orderByDesc('result_date')
            ->paginate(20);

        $categories = GovJobCategory::where('is_active', true)->withCount('jobs')->orderBy('sort_order')->get();
        $recentJobs = GovJob::published()->punjabFirst()->latest()->limit(5)->get();

        return view('jobs.results', compact('results', 'categories', 'recentJobs'));
    }

    // ── Answer Keys Listing ──────────────────────────────
    public function answerKeys(Request $request)
    {
        $answerKeys = GovJobAnswerKey::where('is_published', true)
            ->with('job.category')
            ->orderByDesc('created_at')
            ->paginate(20);

        $categories = GovJobCategory::where('is_active', true)->withCount('jobs')->orderBy('sort_order')->get();
        $recentJobs = GovJob::published()->punjabFirst()->latest()->limit(5)->get();

        return view('jobs.answer-keys', compact('answerKeys', 'categories', 'recentJobs'));
    }

    // ── Form Help Page ───────────────────────────────────
    public function formHelp()
    {
        $categories = GovJobCategory::where('is_active', true)->withCount('jobs')->orderBy('sort_order')->get();
        $recentJobs = GovJob::published()->punjabFirst()->latest()->limit(5)->get();

        return view('jobs.form-help', compact('categories', 'recentJobs'));
    }

    // ── Form Help Submit ─────────────────────────────────
    public function formHelpSubmit(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|min:2|max:100',
            'phone'        => 'required|string|min:10|max:15',
            'email'        => 'nullable|email|max:150',
            'service_type' => 'required|in:job_form,admit_card,result,answer_key,other',
            'job_name'     => 'nullable|string|max:200',
            'message'      => 'nullable|string|max:1000',
        ]);

        $formRequest = GovJobFormRequest::create($validated);

        /* ── Notify (never blocks/fails the response) ── */
        FormNotificationService::send(new FormSubmissionData(
            formType: 'Job Form Help Request',
            referenceNo: null,
            submittedAt: $formRequest->created_at->format('d M Y, h:i A'),
            statusLabel: 'Pending',
            nextSteps: 'Our team will call you within a few hours to assist with your request.',
            recipientName: $formRequest->name,
            recipientEmail: $formRequest->email,
            recipientPhone: $formRequest->phone,
            details: [
                'Help Needed With' => ucwords(str_replace('_', ' ', $formRequest->service_type)),
                'Job / Exam Name'  => $formRequest->job_name,
                'Message'          => $formRequest->message,
            ],
            adminUrl: GovJobFormRequestResource::getUrl('edit', ['record' => $formRequest]),
        ));

        return back()->with('success', 'Your request has been submitted! We will call you within a few hours.');
    }
}
