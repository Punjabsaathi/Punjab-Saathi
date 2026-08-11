@extends('layouts.app')

@section('title', ($query ? 'Search: ' . $query . ' – ' : 'Search Forms – ') . 'Punjab Seva Kendra')

@section('content')

<section class="hero-wrap hero-wrap-2 js-fullheight"
         style="background-image:url('{{ asset('images/bg_1.jpg') }}');"
         data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span>Search <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-3 bread">
                    @if($query) Results for "{{ $query }}" @else Search Forms @endif
                </h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">

            <div class="col-md-3 mb-5">
                <x-form-sidebar :categories="$categories" title="Filter by Category"/>
            </div>

            <div class="col-md-9">

                <form method="GET" action="{{ route('search') }}" class="mb-4">
                    <div class="input-group input-group-lg">
                        <input type="text" name="q" value="{{ $query }}"
                               placeholder="Search for forms, documents, certificates…"
                               class="form-control" style="border-radius:30px 0 0 30px;border-right:none;">
                        <div class="input-group-append">
                            <button class="btn px-4" style="background:#fc5e28;color:#fff;border-radius:0 30px 30px 0;">
                                <span class="fa fa-search mr-1"></span> Search
                            </button>
                        </div>
                    </div>
                </form>

                @if(!$query)
                <div class="text-center py-5 text-muted">
                    <span class="fa fa-search fa-4x mb-3 d-block" style="color:#ddd;"></span>
                    <h5>Enter a keyword to find forms</h5>
                    <p>e.g. "PAN Card", "Passport", "Income Certificate"</p>
                    <div class="mt-3">
                        @foreach(['PAN Card','Passport','Aadhaar','Voter ID','Driving License','Income Certificate'] as $sq)
                            <a href="{{ route('search', ['q' => $sq]) }}"
                               class="btn btn-sm btn-outline-secondary mr-2 mb-2" style="border-radius:20px;font-size:0.8rem;">{{ $sq }}</a>
                        @endforeach
                    </div>
                </div>

                @elseif($results->isEmpty())
                <div class="text-center py-5 text-muted">
                    <span class="fa fa-frown-o fa-4x mb-3 d-block" style="color:#ddd;"></span>
                    <h5>No results for "{{ $query }}"</h5>
                    <p>Try a different keyword or <a href="{{ route('categories.index') }}" style="color:#fc5e28;">browse by category</a>.</p>
                </div>

                @else
                <p class="text-muted mb-4">
                    Found <strong class="text-dark">{{ $total }}</strong> forms for "<em>{{ $query }}</em>"
                </p>
                <div class="row">
                    @foreach($results as $form)
                        <x-form-card :form="$form" />
                    @endforeach
                </div>
                <div class="mt-4">{{ $results->links() }}</div>
                @endif

            </div>
        </div>
    </div>
</section>

@endsection