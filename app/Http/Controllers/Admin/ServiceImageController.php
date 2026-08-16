<?php

namespace App\Http\Controllers\Admin;

use App\Filament\Resources\ServiceResource;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServiceImageController extends Controller
{
    /**
     * Plain, non-Livewire upload form — the Filament FileUpload field on
     * this resource hangs indefinitely on this environment (stuck on
     * "Waiting for size", never actually writes the temp file), so this
     * bypasses Livewire's async upload flow entirely with a classic
     * full-page multipart form submit instead.
     */
    public function edit(Service $service): View
    {
        return view('admin.services.image-upload', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:5120'],
        ]);

        if ($service->og_image) {
            Storage::disk('public')->delete($service->og_image);
        }

        $path = $request->file('image')->store('services', 'public');

        $service->update(['og_image' => $path]);

        return redirect()
            ->to(ServiceResource::getUrl('edit', ['record' => $service]))
            ->with('success', 'Service image updated.');
    }
}
