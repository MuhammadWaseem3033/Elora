@extends('layouts.app')

@section('title', $category->name . ' | ÉLORA')
@section('meta_description', $category->description ?: 'Explore ' . $category->name . ' fashion designs at ÉLORA.')

@section('content')

    {{-- Category Hero --}}
    <section class="page-hero">
        <span class="eyebrow">ÉLORA / The edit</span>

        <h1>{{ $category->name }}</h1>

        <p>
            {{ $category->description ?: 'Explore our curated fashion collection and discover timeless style inspiration.' }}
        </p>
    </section>

    {{-- Category Designs --}}
    <section class="section container">

        <div class="filter-row">
            <span class="meta">
                Curated design studies · {{ $category->designs->count() }} stories
            </span>

            <input class="search" type="search" data-search placeholder="Search this collection..."
                aria-label="Search this collection">
        </div>

        @if ($category->designs->isNotEmpty())

            <div class="grid-4">

                @foreach ($category->designs as $design)
                    <article class="design-card" data-searchable>
                        <a href="{{ route('design.show', $design->slug) }}">
                            @php
                                $image = $design->featured_image ?: $category->image;
                            @endphp

                            @if ($image)
                                <img src="{{ asset($image) }}" alt="{{ $design->title }}" loading="lazy">
                            @endif

                            <span class="meta">
                                Design study · {{ sprintf('%02d', $loop->iteration) }}
                            </span>

                            <h3>{{ $design->title }}</h3>

                            <p>
                                {{ $design->short_description ?: 'Discover this curated fashion design from ÉLORA.' }}
                            </p>

                            <span class="text-link">Explore design</span>
                        </a>
                    </article>
                @endforeach

            </div>
        @else
            <div class="notice">
                No published designs are available in this category yet.
                Please check back soon.
            </div>

        @endif

    </section>

@endsection
