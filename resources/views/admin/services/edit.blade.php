@extends('layouts.admin')

@section('content')

<div class="container-fluid pt-4 px-4">

    <div class="bg-secondary rounded p-4">

        <h4 class="mb-4">Edit Service</h4>

        <form action="{{ route('admin.services.update', $service) }}"
              method="POST">

            @csrf
            @method('PUT')

            @include('admin.services.form')

            <button class="btn btn-primary">
                Update Service
            </button>

        </form>

    </div>

</div>

@endsection