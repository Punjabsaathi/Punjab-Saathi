@extends('admin.layouts.app')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6>Application: {{ $application->reference_no }}</h6>
            {!! $application->status_badge !!}
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <p><strong>Service:</strong> {{ $application->service->title }}</p>
                <p><strong>Applicant:</strong> {{ $application->name }}</p>
                <p><strong>Phone:</strong> {{ $application->phone }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p><strong>Submitted On:</strong> {{ $application->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <h6 class="mt-4 border-bottom pb-2">Uploaded Documents</h6>
        <div class="list-group">
            @foreach($application->document_paths as $label => $path)
                <div class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>{{ $label }}</span>
                    <a href="{{ asset('storage/'.$path) }}" target="_blank" class="btn btn-sm btn-primary">View / Download</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection