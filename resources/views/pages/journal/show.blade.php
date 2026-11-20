@extends('layouts.app')

@section('title', $article->meta_title ?: $article->title . ' | ÉLORA')

@section('meta_description', $article->meta_description ?: $article->excerpt)


@section('canonical_url', route('journal.show', $article->slug))

@section('meta_image', $article->featured_image ? asset($article->featured_image) : '')

@section('og_type', 'article')

@php
    $articleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $article->title,
        'description' => $article->excerpt ?: $article->title,
        'url' => route('journal.show', $article->slug),
        'image' => $article->featured_image ? asset($article->featured_image) : null,
        'datePublished' => $article->published_at ? $article->published_at->toAtomString() : null,
        'dateModified' => $article->updated_at->toAtomString(),
        'author' => [
            '@type' => 'Person',
            'name' => $article->author ?: 'ÉLORA Editorial Team',
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'ÉLORA',
            'url' => config('app.url'),
        ],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => route('journal.show', $article->slug),
        ],
    ];

    $articleSchemaJson = json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $articleBreadcrumb = [
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
                'name' => 'Journal',
                'item' => route('journal.index'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $article->title,
                'item' => route('journal.show', $article->slug),
            ],
        ],
    ];

    $articleBreadcrumbJson = json_encode($articleBreadcrumb, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@endphp

<script type="application/ld+json">
    {!! $articleSchemaJson !!}
</script>

<script type="application/ld+json">
    {!! $articleBreadcrumbJson !!}
</script>


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
                @if ($article->featured_image)
                    <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}"
                        style="width:100%; max-height:550px; object-fit:cover;" fetchpriority="high" decoding="async">
                @endif

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
                            <img 
                                src="{{ asset($related->featured_image) }}" 
                                alt="{{ $related->title }}"
                                loading="lazy" 
                                decoding="async"
                            >
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
