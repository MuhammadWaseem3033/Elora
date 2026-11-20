@extends('layouts.app')

@section('title', $design->meta_title ?: $design->title . ' | ÉLORA')

@section('meta_description', $design->meta_description ?: $design->short_description)


@section('canonical_url', route('design.show', $design->slug))

@section('meta_image', $design->featured_image ? asset($design->featured_image) : '')

@section('og_type', 'article')

@php
    $designSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CreativeWork',
        'name' => $design->title,
        'description' => $design->short_description ?: $design->title,
        'url' => route('design.show', $design->slug),
        'image' => $design->featured_image ? asset($design->featured_image) : null,
        'creator' => $design->designer ?: 'ÉLORA Editorial Team',
        'genre' => $design->category->name,
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'ÉLORA',
            'url' => config('app.url'),
        ],
    ];

    $designSchemaJson = json_encode($designSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $designBreadcrumb = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => route('home'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $design->category->name,
                'item' => route('category.show', $design->category->slug),
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $design->title,
                'item' => route('design.show', $design->slug),
            ],
        ],
    ];

    $designBreadcrumbJson = json_encode($designBreadcrumb, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@endphp

<script type="application/ld+json">
    {!! $designSchemaJson !!}
</script>

<script type="application/ld+json">
    {!! $designBreadcrumbJson !!}
</script>


@section('content')
    @include('partials.advertisements', ['placement' => 'design_detail_top'])
    <section class="page-hero">
        <span class="eyebrow">
            ÉLORA /
            <a href="{{ route('category.show', $design->category->slug) }}">
                {{ $design->category->name }}
            </a>
        </span>

        <h1>{{ $design->title }}</h1>

        @if ($design->short_description)
            <p>{{ $design->short_description }}</p>
        @endif
    </section>

    <section class="section container">

        <div class="mb-4">
            <a href="{{ route('category.show', $design->category->slug) }}" class="text-link">
                ← Back to {{ $design->category->name }}
            </a>
        </div>

        <div class="row g-5">

            <div class="col-lg-8">

                @if ($design->featured_image)
                    <div class="mb-4">
                        <img 
                            src="{{ asset($design->featured_image) }}" 
                            alt="{{ $design->title }}" fetchpriority="high"
                            decoding="async" 
                            style="width:100%; max-height:650px; object-fit:cover;"
                        >
                        {{-- <img src="{{ asset($design->featured_image) }}" alt="{{ $design->title }}"
                            style="width:100%; max-height:650px; object-fit:cover;"> --}}
                    </div>
                @endif

                @if ($design->images->isNotEmpty())

                    <div class="row g-3">

                        @foreach ($design->images as $image)
                            <div class="col-md-6">
                                <img
                                    src="{{ asset($image->image) }}"
                                    alt="{{ $image->alt_text ?: $design->title }}"
                                    loading="lazy"
                                    decoding="async"
                                    style="width:100%; height:350px; object-fit:cover;"
                                >
                                {{-- <img src="{{ asset($image->image) }}" alt="{{ $image->alt_text ?: $design->title }}"
                                    loading="lazy" style="width:100%; height:350px; object-fit:cover;"> --}}
                            </div>
                        @endforeach

                    </div>

                @endif

            </div>

            <div class="col-lg-4">

                <span class="eyebrow">DESIGN DETAILS</span>

                <h2>{{ $design->title }}</h2>

                @if ($design->designer)
                    <p><strong>Designer:</strong> {{ $design->designer }}</p>
                @endif

                @if ($design->collection_name)
                    <p><strong>Collection:</strong> {{ $design->collection_name }}</p>
                @endif

                <p>
                    <strong>Category:</strong>
                    <a href="{{ route('category.show', $design->category->slug) }}">
                        {{ $design->category->name }}
                    </a>
                </p>

                @if ($design->description)
                    <div class="mt-4">
                        {!! $design->description !!}
                    </div>
                @endif

            </div>

        </div>

        {{-- Previous and Next --}}

        <div class="d-flex justify-content-between flex-wrap gap-3 mt-5">

            <div>
                @if ($previousDesign)
                    <span class="meta">PREVIOUS DESIGN</span>
                    <br>
                    <a href="{{ route('design.show', $previousDesign->slug) }}" class="text-link">
                        ← {{ $previousDesign->title }}
                    </a>
                @endif
            </div>

            <div class="text-end">
                @if ($nextDesign)
                    <span class="meta">NEXT DESIGN</span>
                    <br>
                    <a href="{{ route('design.show', $nextDesign->slug) }}" class="text-link">
                        {{ $nextDesign->title }} →
                    </a>
                @endif
            </div>

        </div>

    </section>

    {{-- Related Designs --}}

    @if ($relatedDesigns->isNotEmpty())

        <section class="section container">

            <div class="section-head">
                <div>
                    <span class="eyebrow">DISCOVER MORE</span>
                    <h2>Related Designs</h2>
                </div>

                <a href="{{ route('category.show', $design->category->slug) }}" class="text-link">
                    View All Designs →
                </a>
            </div>

            <div class="grid-4">

                @foreach ($relatedDesigns as $related)
                    <a href="{{ route('design.show', $related->slug) }}" class="design-card">

                        @if ($related->featured_image)
                            <img src="{{ asset($related->featured_image) }}" alt="{{ $related->title }}" loading="lazy">
                        @endif

                        <span class="meta">
                            {{ $design->category->name }}
                        </span>

                        <h3>{{ $related->title }}</h3>

                        <p>{{ $related->short_description }}</p>

                        <span class="text-link">Explore Design →</span>

                    </a>
                @endforeach

            </div>

        </section>

    @endif

@endsection
