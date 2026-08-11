<div class="bg-secondary rounded p-4">
    <h6 class="mb-4">Recent Service Applications</h6>
    <div class="table-responsive">
        <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead>
                <tr class="text-white">
                    <th>Ref No</th>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                <tr>
                    <td>{{ $app->reference_no }}</td>
                    <td>{{ $app->created_at->format('d M Y') }}</td>
                    <td>{{ $app->service->title }}</td>
                    <td>{{ $app->name }}</td>
                    <td>{!! $app->status_badge !!}</td>
                    <td><a class="btn btn-sm btn-primary" href="">View Files</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>