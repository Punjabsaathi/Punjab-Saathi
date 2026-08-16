<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Upload Service Image - {{ $service->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
</head>
<body style="background:var(--dark);">
    <div class="container py-5" style="max-width:560px;">
        <div class="bg-secondary rounded p-4 p-sm-5">

            <h4 class="mb-1">Upload Service Image</h4>
            <p class="mb-4" style="color:var(--light);">{{ $service->title }}</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                <script>
                    // Loaded inside the Filament edit page's iframe — reload
                    // the parent so the updated image shows there too,
                    // instead of just inside this small iframe.
                    if (window.parent && window.parent !== window) {
                        window.parent.location.reload();
                    }
                </script>
            @endif

            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @if($service->image_url)
                <p class="mb-2" style="font-size:13px;color:var(--light);">Current image:</p>
                <img src="{{ $service->image_url }}" alt="{{ $service->title }}"
                     style="max-width:100%;border-radius:10px;margin-bottom:24px;border:1px solid var(--border);">
            @endif

            <form method="POST"
                  action="{{ route('admin.services.image.update', $service) }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Choose an image (JPG, PNG, WebP — max 5MB)</label>
                    <input type="file" name="image" accept="image/*" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary py-2 w-100">
                    Upload
                </button>

                <a href="{{ \App\Filament\Resources\ServiceResource::getUrl('edit', ['record' => $service]) }}"
                   class="btn btn-secondary border py-2 w-100 mt-2">
                    Back to Service
                </a>
            </form>

        </div>
    </div>
</body>
</html>
