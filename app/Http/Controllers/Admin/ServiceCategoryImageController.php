<?php

namespace App\Http\Controllers\Admin;

use App\Filament\Resources\ServiceCategoryResource;
use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServiceCategoryImageController extends Controller
{
    /**
     * Same plain, non-Livewire upload workaround used for Service's own
     * image (see ServiceImageController) — Filament's FileUpload hangs
     * indefinitely on this environment.
     */
    public function edit(ServiceCategory $serviceCategory): View
    {
        return view('admin.service-categories.image-upload', ['category' => $serviceCategory]);
    }

    public function update(Request $request, ServiceCategory $serviceCategory): RedirectResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:5120'],
        ]);

        if ($serviceCategory->image) {
            Storage::disk('public')->delete($serviceCategory->image);
        }

        $path = $request->file('image')->store('services', 'public');

        $serviceCategory->update(['image' => $path]);

        return redirect()
            ->to(ServiceCategoryResource::getUrl('edit', ['record' => $serviceCategory]))
            ->with('success', 'Category image updated.');
    }
}
