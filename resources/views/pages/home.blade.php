@extends('layouts.app')

@section('title', 'Home | ÉLORA')

@section('meta_description',
    'ÉLORA — an independent fashion and lifestyle journal. Discover fashion designs, styling
    notes and editorial stories.')

@section('content')

    {{-- Hero Section --}}
    @include('partials.advertisements', ['placement' => 'home_top'])
    <section class="hero">
        <div class="hero-copy">
            <span class="eyebrow">A point of view on modern style</span>

            <h1>Style is in<br>the details.</h1>

            <p>
                ÉLORA is an independent fashion journal for curious eyes
                and considered wardrobes. Discover design stories,
                styling notes and the details worth noticing.
            </p>

            <a class="btn" href="{{ url('/journal') }}">
                Explore the journal
            </a>
        </div>

        <div class="hero-image"
            style="background-image:url('https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1400&q=90')">
        </div>

    </section>


    {{-- Categories Section --}}
    <section class="section container">

        <div class="section-head">

            <div>
                <span class="eyebrow">The edit</span>
                <h2>Explore the categories</h2>
            </div>

            <p>
                Four perspectives on personal style, from wardrobe
                foundations to finishing details.
            </p>

        </div>

        <div class="grid-4">

            @forelse($categories as $category)
                <a class="category-card" href="{{ url('/category/' . $category->slug) }}">

                    @if ($category->image)
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                    @endif

                    <div class="card-label">
                        <span>Explore the edit</span>
                        <h3>{{ $category->name }}</h3>
                    </div>

                </a>

            @empty

                <p>No categories available yet.</p>
            @endforelse

        </div>

    </section>


    {{-- Quote Section --}}
    <div class="quote-band">

        <blockquote>
            “Elegance is not about being noticed. It is about being remembered.”
        </blockquote>

        <span class="meta">ÉLORA editorial note</span>

    </div>


    {{-- Journal Section --}}
    <section class="section container">

        <div class="section-head">

            <div>
                <span class="eyebrow">Fresh perspective</span>
                <h2>From the journal</h2>
            </div>

            <a class="text-link" href="{{ url('/journal') }}">
                View all stories
            </a>

        </div>

        <div class="grid-3">

            @forelse($articles as $article)
                <a class="story-card" href="{{ url('/journal/' . $article->slug) }}">

                    @if ($article->featured_image)
                        <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}">
                    @endif

                    <span class="meta">
                        {{ $article->blogCategory?->name ?? 'Journal' }}
                    </span>

                    <h3>{{ $article->title }}</h3>

                    <p>
                        {{ $article->excerpt }}
                    </p>

                </a>

            @empty

                <p>No journal articles available yet.</p>
            @endforelse

        </div>

    </section>


    {{-- Editorial Notice --}}
    <section class="section container">

        <div class="notice">

            <b>For readers and curious minds.</b>

            ÉLORA is an editorial inspiration website, not an online store.
            We do not sell products or process purchases.

        </div>

    </section>

@endsection
