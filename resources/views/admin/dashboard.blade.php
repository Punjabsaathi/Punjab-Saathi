@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('content')

{{-- Stats Cards --}}
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-envelope fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Inquiries</p>
                    <h6 class="mb-0">0</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-blog fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Blogs</p>
                    <h6 class="mb-0">0</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-project-diagram fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Projects</p>
                    <h6 class="mb-0">0</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-users fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Users</p>
                    <h6 class="mb-0">0</h6>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Monthly Inquiries</h6>
                </div>
                <canvas id="worldwide-sales"></canvas>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Blog Posts Overview</h6>
                    <a href="{{ route('admin.blogs.index') }}">Show All</a>
                </div>
                <canvas id="salse-revenue"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Recent Blogs & Quick Actions --}}
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">

        {{-- Recent Blogs --}}
        <div class="col-sm-12 col-md-6 col-xl-6">
            <div class="h-100 bg-secondary rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Recent Blog Posts</h6>
                    <a href="{{ route('admin.blogs.index') }}">Show All</a>
                </div>
                @forelse($recentBlogs ?? [] as $blog)
                <div class="d-flex align-items-center border-bottom py-3">
                    <i class="fa fa-file-alt fa-2x text-primary flex-shrink-0"></i>
                    <div class="w-100 ms-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-0">{{ Str::limit($blog->title, 30) }}</h6>
                            <small>{{ $blog->created_at->diffForHumans() }}</small>
                        </div>
                        <span>{{ ucfirst($blog->status ?? 'draft') }}</span>
                    </div>
                </div>
                @empty
                <p class="text-center mt-3">No blog posts yet</p>
                @endforelse
                <div class="mt-3">
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm w-100">
                        <i class="fa fa-plus me-2"></i>Add New Post
                    </a>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-sm-12 col-md-6 col-xl-6">
            <div class="h-100 bg-secondary rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i>Add Blog Post
                    </a>
                    <a href="{{ url('/') }}" class="btn btn-secondary border" target="_blank">
                        <i class="fa fa-eye me-2"></i>View Frontend
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    // Monthly Inquiries Chart
    var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
    new Chart(ctx1, {
        type: "bar",
        data: {
            labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
            datasets: [{
                label: "Inquiries",
                data: [15, 25, 20, 35, 30, 45, 40, 55, 50, 60, 55, 70],
                backgroundColor: "rgba(0, 156, 255, .7)"
            }]
        },
        options: { responsive: true }
    });

    // Blog Overview Chart
    var ctx2 = $("#salse-revenue").get(0).getContext("2d");
    new Chart(ctx2, {
        type: "line",
        data: {
            labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul"],
            datasets: [{
                label: "Blog Posts",
                data: [3, 7, 5, 10, 8, 15, 12],
                backgroundColor: "rgba(0, 156, 255, .3)",
                borderColor: "rgba(0, 156, 255, 1)",
                fill: true
            }]
        },
        options: { responsive: true }
    });
</script>
@endpush