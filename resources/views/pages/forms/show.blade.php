@extends('layouts.app')

@section('title', ($form->seo_title ?? $form->title) . ' – Punjab Seva Kendra')
@section('meta_description', $form->meta_description ?? $form->short_description)

@section('content')

<script type="application/ld+json">{!! $schemaMarkup !!}</script>

<section class="hero-wrap hero-wrap-2 js-fullheight"
         style="background-image:url('{{ asset('images/bg_1.jpg') }}');"
         data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span class="mr-2"><a href="{{ route('categories.index') }}">Categories <i class="fa fa-chevron-right"></i></a></span>
                    <span class="mr-2"><a href="{{ route('categories.show', $form->category->slug) }}">{{ $form->category->name }} <i class="fa fa-chevron-right"></i></a></span>
                    <span>{{ \Illuminate\Support\Str::limit($form->title, 40) }} <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-3 bread">{{ $form->title }}</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">

            <div class="col-md-3 mb-5">
                <x-form-sidebar :categories="$categories"/>
            </div>

            <div class="col-md-9">

                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <div class="row align-items-start">
                            <div class="col-md-2 text-center mb-3 mb-md-0">
                                <div class="d-flex align-items-center justify-content-center rounded mx-auto"
                                     style="width:80px;height:80px;background:rgba(252,94,40,0.10);">
                                    <span class="fa fa-file-pdf-o" style="font-size:2.2rem;color:#fc5e28;"></span>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-2">
                                    <span class="badge mr-1" style="background:rgba(252,94,40,0.1);color:#fc5e28;font-size:0.75rem;">{{ $form->category->name }}</span>
                                    @if($form->subcategory)
                                        <span class="badge badge-light" style="font-size:0.75rem;">{{ $form->subcategory->name }}</span>
                                    @endif
                                    @if($form->is_featured)
                                        <span class="badge" style="background:#fff3cd;color:#856404;font-size:0.75rem;"><span class="fa fa-star mr-1"></span>Featured</span>
                                    @endif
                                    @if($form->is_popular)
                                        <span class="badge" style="background:#ffe0d9;color:#c0392b;font-size:0.75rem;"><span class="fa fa-fire mr-1"></span>Popular</span>
                                    @endif
                                </div>

                                <h3 style="font-weight:700;font-size:1.4rem;">{{ $form->title }}</h3>

                                @if($form->short_description)
                                    <p class="text-muted mb-3">{{ $form->short_description }}</p>
                                @endif

                                <div class="mb-4" style="font-size:0.82rem;color:#888;">
                                    <span class="mr-3"><span class="fa fa-download mr-1" style="color:#fc5e28;"></span>{{ number_format($form->download_count) }} downloads</span>
                                    @if($form->file_size)<span class="mr-3"><span class="fa fa-hdd-o mr-1"></span>{{ $form->file_size_human }}</span>@endif
                                    @if($form->published_date)<span><span class="fa fa-calendar mr-1"></span>{{ $form->published_date->format('d M Y') }}</span>@endif
                                </div>

                                <a href="{{ route('forms.download', $form->slug) }}"
                                   class="btn btn-lg" style="background:#fc5e28;color:#fff;border-radius:25px;padding:10px 30px;">
                                    <span class="fa fa-download mr-2"></span>Download Form
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if($form->full_description)
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <h5 class="font-weight-bold mb-3">About this Form</h5>
                        <div style="line-height:1.8;color:#555;">{!! $form->full_description !!}</div>
                    </div>
                </div>
                @endif

                @if($form->tags->isNotEmpty())
                <div class="mb-4">
                    @foreach($form->tags as $tag)
                        <a href="{{ route('search', ['q' => $tag->name]) }}"
                           class="badge mr-1 mb-1 py-1 px-2"
                           style="background:rgba(252,94,40,0.1);color:#fc5e28;font-size:0.8rem;text-decoration:none;border-radius:20px;">
                            <span class="fa fa-tag mr-1"></span>{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
                @endif

                @if($form->faqs->isNotEmpty())
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <h5 class="font-weight-bold mb-3">
                            <span class="fa fa-question-circle mr-2" style="color:#fc5e28;"></span>Frequently Asked Questions
                        </h5>
                        <div id="faqAccordion">
                            @foreach($form->faqs as $faq)
                            <div class="card border-0 mb-2" style="background:#f8f9fa;border-radius:8px;overflow:hidden;">
                                <div class="card-header bg-transparent border-0 p-0">
                                    <button class="btn btn-block text-left d-flex justify-content-between align-items-center px-3 py-2"
                                            type="button" data-toggle="collapse" data-target="#faq{{ $loop->index }}"
                                            style="font-size:0.9rem;font-weight:600;color:#333;">
                                        {{ $faq->question }}
                                        <span class="fa fa-chevron-down ml-2" style="color:#fc5e28;font-size:0.75rem;"></span>
                                    </button>
                                </div>
                                <div id="faq{{ $loop->index }}" class="collapse {{ $loop->first ? 'show' : '' }}" data-parent="#faqAccordion">
                                    <div class="card-body pt-0 px-3 pb-3" style="font-size:0.87rem;color:#555;line-height:1.7;">
                                        {!! nl2br(e($faq->answer)) !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                @if($related->isNotEmpty())
                <div class="mb-4">
                    <h5 class="font-weight-bold mb-3">
                        <span class="fa fa-files-o mr-2" style="color:#fc5e28;"></span>Related Forms
                    </h5>
                    <div class="row">
                        @foreach($related as $rf)
                            <x-form-card :form="$rf" />
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

@endsection