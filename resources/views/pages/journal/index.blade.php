@extends('layouts.app')

@section('title', ($selectedCategory?->name ?? 'The Journal') . ' | ÉLORA')

@section('meta_description',
    $selectedCategory?->description ?:
    'Explore fashion stories, style inspiration and
    editorial perspectives at ÉLORA.')

    @push('styles')
        <style>
            .journal-categories {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                align-items: center;
                margin: 25px 0 35px;
            }

            .journal-categories a {
                display: inline-block;
                padding: 10px 20px;
                border: 1px solid #dfd2c5;
                color: #603342;
                text-decoration: none;
                font-size: 13px;
                transition: .3s ease;
            }

            .journal-categories a:hover,
            .journal-categories a.active {
                background: #603342;
                border-color: #603342;
                color: #fff;
            }
        </style>
    @endpush

@section('content')
@include('partials.advertisements', ['placement' => 'journal_top'])
    <section class="page-hero">
        <span class="eyebrow">ÉLORA / Notes & Perspectives</span>

        <h1>The Journal</h1>

        <p>
            Original editorial stories on personal style, design language,
            craftsmanship and the considered life.
        </p>
    </section>

    <section class="section container">

        <div class="filter-row">
            <span class="meta">EDITORIAL STORIES</span>

            <input class="search" type="search" data-search placeholder="Search journal..." aria-label="Search journal">
        </div>

        {{-- Blog Categories --}}
        <div class="journal-categories">

            <a href="{{ route('journal.index') }}" class="{{ !$selectedCategory ? 'active' : '' }}">
                All Stories
            </a>

            @foreach ($blogCategories as $category)
                <a href="{{ route('journal.category', $category->slug) }}"
                    class="{{ $selectedCategory?->id === $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach

        </div>

        {{-- Selected Category Heading --}}
        @if ($selectedCategory)
            <div class="mb-4">
                <h2>{{ $selectedCategory->name }}</h2>

                @if ($selectedCategory->description)
                    <p>{{ $selectedCategory->description }}</p>
                @endif
            </div>
        @endif

        {{-- Articles --}}
        @if ($articles->isNotEmpty())

            <div class="grid-3">

                @foreach ($articles as $article)
                    <a href="{{ route('journal.show', $article->slug) }}" class="design-card">
                        <article class="design-card" data-searchable>

                            @if ($article->featured_image)
                                <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}" loading="lazy">
                            @endif

                            <span class="meta">
                                {{ $article->blogCategory?->name ?? 'Journal' }}
                            </span>

                            <h3>{{ $article->title }}</h3>

                            <p>{{ $article->excerpt }}</p>

                            <span class="meta">
                                By {{ $article->author ?: 'ÉLORA Editorial Team' }}
                            </span>

                            @if ($article->published_at)
                                <span class="meta">
                                    {{ $article->published_at->format('M d, Y') }}
                                </span>
                            @endif

                        </article>
                    </a>
                @endforeach

            </div>

            <div class="mt-5">
                {{ $articles->links() }}
            </div>
        @else
            <div class="notice">
                No articles are available in this category yet.
            </div>

        @endif

    </section>

@endsection
