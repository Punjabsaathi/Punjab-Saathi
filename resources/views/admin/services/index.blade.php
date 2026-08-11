@extends('layouts.admin')

@section('content')

<div class="container-fluid pt-4 px-4">

    <div class="bg-secondary rounded p-4">

        <div class="d-flex justify-content-between mb-4">
            <h4>Services</h4>

            <a href="{{ route('admin.services.create') }}"
               class="btn btn-primary">
                Add Service
            </a>
        </div>

        <table class="table table-dark">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Popular</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach($services as $service)

                <tr>
                    <td>{{ $service->id }}</td>

                    <td>{{ $service->title }}</td>

                    <td>{{ $service->category }}</td>

                    <td>
                        @if($service->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>

                    <td>
                        @if($service->is_popular)
                            <span class="badge bg-warning">Popular</span>
                        @endif
                    </td>

                    <td>

                        <a href="{{ route('admin.services.edit', $service) }}"
                           class="btn btn-sm btn-info">
                            Edit
                        </a>

                        <form action="{{ route('admin.services.destroy', $service) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete Service?')">
                                Delete
                            </button>

                        </form>

                    </td>
                </tr>

                @endforeach

            </tbody>

        </table>

        {{ $services->links() }}

    </div>

</div>

@endsection