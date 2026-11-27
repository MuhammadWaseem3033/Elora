@extends('layouts.app')

@section('title', "ÉLORA | Women's Fashion, Style & Latest Fashion Trends")

@section('meta_description',
    "Discover the latest women's fashion trends, elegant designs, 
    bridal collections, styling inspiration and editorial stories at ÉLORA.")

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

        {{-- <div class="hero-image"
            style="background-image:url('https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1400&q=90')">
        </div> --}}
        <div class="hero-image" id="heroImage">
            @foreach ($featuredDesigns->filter(fn($design) => filled($design->featured_image)) as $design)
                <div class="hero-slide {{ $loop->first ? 'active' : '' }}"
                    style="background-image: url('{{ asset($design->featured_image) }}');" role="img"
                    aria-label="{{ $design->title }}"></div>
            @endforeach
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

        <div class="grid-3">

            @forelse($categories as $category)
                <a class="category-card" href="{{ url('/category/' . $category->slug) }}">

                    @if ($category->image)
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" loading="lazy"
                            decoding="async">
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

        <div class="grid-3 journal-animated-grid">

            @forelse($articles as $article)
                <a class="story-card" href="{{ url('/journal/' . $article->slug) }}">

                    @if ($article->featured_image)
                        <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}" loading="lazy"
                            decoding="async">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const journalCards = document.querySelectorAll(
                '.journal-animated-grid .story-card'
            );

            if (!('IntersectionObserver' in window)) {
                journalCards.forEach(card => card.classList.add('show'));
                return;
            }

            const observer = new IntersectionObserver((entries) => {

                entries.forEach(entry => {

                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');

                        observer.unobserve(entry.target);
                    }

                });

            }, {
                threshold: 0.1
            });

            journalCards.forEach(card => {
                observer.observe(card);
            });

        });

        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('#heroImage .hero-slide');

            if (slides.length <= 1) return;

            let currentSlide = 0;

            setInterval(() => {
                slides[currentSlide].classList.remove('active');

                currentSlide = (currentSlide + 1) % slides.length;

                slides[currentSlide].classList.add('active');
            }, 60000);
        });
    </script>
@endsection
