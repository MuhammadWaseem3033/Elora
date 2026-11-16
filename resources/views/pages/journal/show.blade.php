@extends('layouts.app')

@section('title', $article->meta_title ?: $article->title . ' | ÉLORA')

@section('meta_description', $article->meta_description ?: $article->excerpt)

@section('content')
    @include('partials.advertisements', ['placement' => 'journal_detail_top'])
    <section class="page-hero">
        <span class="eyebrow">ÉLORA / Journal / Article</span>

        <h1>{{ $article->title }}</h1>

        <p>{{ $article->excerpt }}</p>

        <div class="meta">
            By {{ $article->author ?: 'ÉLORA Editorial Team' }}

            @if ($article->published_at)
                · {{ $article->published_at->format('F d, Y') }}
            @endif
        </div>
    </section>

    <section class="section container">

        <div class="mb-4">
            <a href="{{ route('journal.index') }}" class="text-link">
                ← Back to Journal
            </a>

            @if ($article->blogCategory)
                <span class="meta ms-3">
                    Category:
                    <a href="{{ route('journal.category', $article->blogCategory->slug) }}">
                        {{ $article->blogCategory->name }}
                    </a>
                </span>
            @endif
        </div>

        @if ($article->featured_image)
            <div class="mb-5">
                <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}"
                    style="width:100%; max-height:550px; object-fit:cover;">
            </div>
        @endif

        <div class="article-content">
            {!! $article->content !!}
        </div>

        <div class="mt-5">
            <a href="{{ route('journal.index') }}" class="text-link">
                ← Explore More Stories
            </a>
        </div>

    </section>

    @if ($relatedArticles->isNotEmpty())
        <section class="section container">
            <div class="section-head">
                <div>
                    <span class="eyebrow">KEEP EXPLORING</span>
                    <h2>Related Stories</h2>
                </div>
                <a href="{{ route('journal.index') }}" class="text-link">
                    View All Stories →
                </a>
            </div>

            <div class="grid-3">
                @foreach ($relatedArticles as $related)
                    <a href="{{ route('journal.show', $related->slug) }}" class="design-card">

                        @if ($related->featured_image)
                            <img src="{{ asset($related->featured_image) }}" alt="{{ $related->title }}">
                        @endif

                        <span class="meta">
                            {{ $related->blogCategory?->name }}
                        </span>

                        <h3>{{ $related->title }}</h3>

                        <p>{{ $related->excerpt }}</p>

                        <span class="text-link">Read Story →</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection
