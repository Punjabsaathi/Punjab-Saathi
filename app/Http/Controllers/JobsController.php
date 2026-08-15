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
use App\Services\FormNotificationService;
use App\Support\FormSubmissionData;

class JobsController extends Controller
{
    // ── Main Jobs Listing ────────────────────────────────
    public function index(Request $request)
    {
        $categories = GovJobCategory::where('is_active', true)
            ->withCount(['jobs', 'activeJobs'])
            ->orderBy('sort_order')
            ->get();

        $query = GovJob::published()
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at');

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
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

        $recentJobs = GovJob::published()->latest()->limit(5)->get();

        return view('jobs.index', compact('jobs', 'categories', 'stats', 'recentJobs'));
    }

    // ── Jobs by Category ─────────────────────────────────
    public function category(Request $request, $slug)
    {
        $category = GovJobCategory::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $categories = GovJobCategory::where('is_active', true)
            ->withCount('jobs')->orderBy('sort_order')->get();

        $jobs = GovJob::published()
            ->where('category_id', $category->id)
            ->with('category')
            ->orderByDesc('created_at')
            ->paginate(15)->withQueryString();

        $stats = [
            'total'    => GovJob::published()->count(),
            'active'   => GovJob::published()->where('status', 'active')->count(),
            'upcoming' => GovJob::published()->where('status', 'upcoming')->count(),
        ];

        $recentJobs = GovJob::published()->latest()->limit(5)->get();

        return view('jobs.index', compact('jobs', 'categories', 'stats', 'recentJobs', 'category'));
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

        return view('jobs.show', compact('job', 'relatedJobs', 'categories', 'metaTitle', 'metaDesc'));
    }

    // ── Admit Cards Listing ──────────────────────────────
    public function admitCards(Request $request)
    {
        $cards = GovJobAdmitCard::where('is_published', true)
            ->with('job.category')
            ->orderByDesc('created_at')
            ->paginate(20);

        $categories  = GovJobCategory::where('is_active', true)->withCount('jobs')->orderBy('sort_order')->get();
        $recentJobs  = GovJob::published()->latest()->limit(5)->get();

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
        $recentJobs = GovJob::published()->latest()->limit(5)->get();

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
        $recentJobs = GovJob::published()->latest()->limit(5)->get();

        return view('jobs.answer-keys', compact('answerKeys', 'categories', 'recentJobs'));
    }

    // ── Form Help Page ───────────────────────────────────
    public function formHelp()
    {
        $categories = GovJobCategory::where('is_active', true)->withCount('jobs')->orderBy('sort_order')->get();
        $recentJobs = GovJob::published()->latest()->limit(5)->get();

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
