<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceApplication;
use App\Http\Requests\ServiceApplicationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;  // ← make sure this is imported at the top
use App\Models\ServiceDocument;

class ServiceController extends Controller
{
    // ── Service listing page (existing /services route) ──────
        public function index(): View
    {
        $services = Service::active()
            ->with(['documents' => fn($q) => $q->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');
        $totalServices = $services->flatten()->count();
        return view('pages.services', compact('services', 'totalServices'));
    }


    // ── Service detail page: GET /services/{slug} ────────────
    public function show(Service $service): View
    {
        // Abort if inactive (admins can still preview via direct DB)
        // abort_if(!$service->is_active, 404);
        
        $service->load(['documents', 'faqs']);
        $related = $service->related(3);

        // Build FAQ schema for SEO
        $faqSchema = $this->buildFaqSchema($service);

        // Build breadcrumb schema
        $breadcrumbSchema = $this->buildBreadcrumbSchema($service);

        return view('pages.show', compact('service', 'related', 'faqSchema', 'breadcrumbSchema'));
    }

    // ── Handle application form: POST /services/{slug}/apply ─
    public function apply(Request $request, Service $service): RedirectResponse
    {
        $documentPaths = [];
        $request->validate([
        'name'          => 'required|string|max:255',
        'phone'         => 'required|digits:10',
        'email'         => 'nullable|email|max:255',
        'address'       => 'required|string|max:500',
        'message'       => 'nullable|string|max:1000',
        'documents'     => 'nullable|array|max:10',
        'documents.*'   => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);


        // Handle multiple document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store(
                    'applications/' . date('Y/m'),
                    'private'   // stored in storage/app/private — not publicly accessible
                );
                $documentPaths[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'path'          => $path,
                    'size'          => $file->getSize(),
                    'mime'          => $file->getMimeType(),
                ];
            }
        }

        ServiceApplication::create([
            'service_id'     => $service->id,
            'reference_no'   => ServiceApplication::generateReference(),
            'name'           => $request->name,
            'phone'          => $request->phone,
            'email'          => $request->email,
            'address'        => $request->address,
            'message'        => $request->message,
            'document_paths' => $documentPaths ?: null,
            'status'         => 'pending',
            'ip_address'     => $request->ip(),
        ]);

        return redirect()
            ->route('services.show', $service->slug)
            ->with('success', 'Your application has been submitted successfully! We will contact you within 24 hours on your mobile number.')
            ->withFragment('apply-form');  // ← ADD THIS
    }

    // ── Private: Build FAQ JSON-LD schema ────────────────────
    private function buildFaqSchema(Service $service): string
    {
        if ($service->faqs->isEmpty()) {
            return '';
        }

        $schema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $service->faqs->map(fn ($faq) => [
                '@type'          => 'Question',
                'name'           => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $faq->answer,
                ],
            ])->toArray(),
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    // ── Private: Build breadcrumb JSON-LD schema ─────────────
    private function buildBreadcrumbSchema(Service $service): string
    {
        $schema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type'    => 'ListItem',
                    'position' => 1,
                    'name'     => 'Home',
                    'item'     => url('/'),
                ],
                [
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'name'     => 'Services',
                    'item'     => url('/services'),
                ],
                [
                    '@type'    => 'ListItem',
                    'position' => 3,
                    'name'     => $service->title,
                    'item'     => $service->canonical_url,
                ],
            ],
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}