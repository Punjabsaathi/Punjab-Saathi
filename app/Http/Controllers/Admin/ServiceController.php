<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ServiceDocument;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(20);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'short_desc' => 'required',
        ]);

        // CREATE SERVICE
        $service = Service::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),

            'tag' => $request->tag,
            'category' => $request->category,
            'icon' => $request->icon,
            'color' => $request->color,

            'short_desc' => $request->short_desc,
            'overview' => $request->overview,

            'processing_time' => $request->processing_time,
            'fee_range' => $request->fee_range,
            'fee_note' => $request->fee_note,
            'eligibility' => $request->eligibility,

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,

            'is_popular' => $request->has('is_popular'),
            'is_active' => $request->has('is_active'),

            'sort_order' => $request->sort_order ?? 0,
        ]);

        // SAVE FAQS
        if ($request->filled('faqs')) {

            foreach ($request->faqs as $faq) {

                if (!empty($faq['question']) && !empty($faq['answer'])) {

                    $service->faqs()->create([
                        'question' => $faq['question'],
                        'answer' => $faq['answer'],
                    ]);
                }
            }
        }

        // SAVE DOCUMENTS
        if ($request->filled('documents')) {

            foreach ($request->documents as $document) {

                if (!empty($document['name'])) {

                    $service->documents()->create([
                        'name' => $document['name'],
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service Created Successfully');
    }

    public function edit(Service $service)
    {
        $service->load(['faqs', 'documents']);

        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|max:255',
            'short_desc' => 'required',
        ]);

        // UPDATE SERVICE
        $service->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),

            'tag' => $request->tag,
            'category' => $request->category,
            'icon' => $request->icon,
            'color' => $request->color,

            'short_desc' => $request->short_desc,
            'overview' => $request->overview,

            'processing_time' => $request->processing_time,
            'fee_range' => $request->fee_range,
            'fee_note' => $request->fee_note,
            'eligibility' => $request->eligibility,

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,

            'is_popular' => $request->has('is_popular'),
            'is_active' => $request->has('is_active'),

            'sort_order' => $request->sort_order ?? 0,
        ]);

        // DELETE OLD FAQS & DOCUMENTS
        $service->faqs()->delete();
        $service->documents()->delete();

        // SAVE FAQS AGAIN
        if ($request->filled('faqs')) {

            foreach ($request->faqs as $faq) {

                if (!empty($faq['question']) && !empty($faq['answer'])) {

                    $service->faqs()->create([
                        'question' => $faq['question'],
                        'answer' => $faq['answer'],
                    ]);
                }
            }
        }

        // SAVE DOCUMENTS AGAIN
        if ($request->filled('documents')) {

            foreach ($request->documents as $document) {

                if (!empty($document['name'])) {

                    $service->documents()->create([
                        'name' => $document['name'],
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service Updated Successfully');
    }

    public function destroy(Service $service)
    {
        // DELETE RELATIONS
        $service->faqs()->delete();
        $service->documents()->delete();

        // DELETE SERVICE
        $service->delete();

        return back()->with('success', 'Service Deleted Successfully');
    }
}