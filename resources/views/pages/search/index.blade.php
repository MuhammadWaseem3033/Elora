
@extends('layouts.app')

@section('title', $search ? 'Search: '.$search.' | ÉLORA' : 'Search | ÉLORA')

@section('meta_description', 'Search ÉLORA fashion designs and journal articles.')

@section('content')

<section class="elora-search-page">

    <div class="container">

        <div class="search-heading">
            <span class="search-eyebrow">EXPLORE ÉLORA</span>

            <h1>Search Results</h1>

            <form action="{{ route('search.index') }}" method="GET"
                  class="elora-main-search">

                <input
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Search designs, designers, articles..."
                    minlength="2"
                    maxlength="100"
                    required
                >

                <button type="submit">Search</button>
            </form>

            @if($search)
                <p>
                    Results for:
                    <strong>{{ $search }}</strong>
                </p>
            @else
                <p>Discover fashion designs and stories from ÉLORA.</p>
            @endif
        </div>

        @if(mb_strlen($search) >= 2)

            {{-- Fashion Designs --}}

            <section class="search-results-section">

                <div class="search-section-heading">
                    <h2>Fashion Designs</h2>
                    <span>{{ $designs->total() }} Results</span>
                </div>

                @if($designs->count())

                    <div class="row g-4">

                        @foreach($designs as $design)

                            <div class="col-12 col-sm-6 col-lg-4">

                                <a href="{{ route('design.show', $design->slug) }}"
                                   class="search-result-card">

                                    @if($design->featured_image)
                                        <img
                                            src="{{ asset('storage/'.$design->featured_image) }}"
                                            alt="{{ $design->title }}"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="search-image-placeholder">
                                            ÉLORA
                                        </div>
                                    @endif

                                    <div class="search-card-content">

                                        <span>
                                            {{ $design->category->name ?? 'Fashion' }}
                                        </span>

                                        <h3>{{ $design->title }}</h3>

                                        @if($design->designer)
                                            <p>Designer: {{ $design->designer }}</p>
                                        @endif

                                    </div>

                                </a>

                            </div>

                        @endforeach

                    </div>

                    <div class="search-pagination">
                        {{ $designs->links() }}
                    </div>

                @else

                    <p class="search-empty">No fashion designs found.</p>

                @endif

            </section>

            {{-- Journal Articles --}}

            <section class="search-results-section">

                <div class="search-section-heading">
                    <h2>Journal Articles</h2>
                    <span>{{ $articles->total() }} Results</span>
                </div>

                @if($articles->count())

                    <div class="row g-4">

                        @foreach($articles as $article)

                            <div class="col-12 col-sm-6 col-lg-4">

                                <a href="{{ route('journal.show', $article->slug) }}"
                                   class="search-result-card">

                                    @if($article->featured_image)
                                        <img
                                            src="{{ asset('storage/'.$article->featured_image) }}"
                                            alt="{{ $article->title }}"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="search-image-placeholder">
                                            ÉLORA JOURNAL
                                        </div>
                                    @endif

                                    <div class="search-card-content">

                                        <span>
                                            {{ $article->blogCategory->name ?? 'Journal' }}
                                        </span>

                                        <h3>{{ $article->title }}</h3>

                                        <p>
                                            {{ \Illuminate\Support\Str::limit($article->excerpt, 110) }}
                                        </p>

                                    </div>

                                </a>

                            </div>

                        @endforeach

                    </div>

                    <div class="search-pagination">
                        {{ $articles->links() }}
                    </div>

                @else

                    <p class="search-empty">No journal articles found.</p>

                @endif

            </section>

            @if($designs->total() === 0 && $articles->total() === 0)
                <div class="search-no-results">
                    <h2>No Results Found</h2>
                    <p>Try another keyword to discover more from ÉLORA.</p>
                </div>
            @endif

        @elseif($search)

            <div class="search-no-results">
                <h2>Search term is too short</h2>
                <p>Please enter at least 2 characters.</p>
            </div>

        @endif

    </div>

</section>

@endsection

@push('styles')
<style>
.elora-search-page {
    padding: 65px 0 90px;
}

.search-heading {
    text-align: center;
    margin-bottom: 65px;
}

.search-eyebrow {
    color: #a47d4d;
    letter-spacing: 3px;
    font-size: 12px;
}

.search-heading h1 {
    font-family: 'Playfair Display', serif;
    font-size: 42px;
    margin: 12px 0 25px;
}

.elora-main-search {
    display: flex;
    max-width: 650px;
    margin: 0 auto 18px;
    border: 1px solid #d8c9b7;
}

.elora-main-search input {
    flex: 1;
    min-width: 0;
    border: 0;
    outline: none;
    padding: 15px;
}

.elora-main-search button {
    border: 0;
    padding: 0 28px;
    background: #522c35;
    color: #fff;
}

.search-results-section {
    margin-bottom: 60px;
}

.search-section-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #ded5cb;
    padding-bottom: 15px;
    margin-bottom: 25px;
}

.search-section-heading h2 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    margin: 0;
}

.search-section-heading span {
    color: #8b7768;
    font-size: 13px;
}

.search-result-card {
    display: block;
    height: 100%;
    text-decoration: none;
    color: #292522;
    background: #fff;
    border: 1px solid #eee8e1;
    transition: transform .25s ease, box-shadow .25s ease;
}

.search-result-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    color: #522c35;
}

.search-result-card img,
.search-image-placeholder {
    width: 100%;
    height: 290px;
    object-fit: cover;
}

.search-image-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f0e9e1;
    color: #80664e;
    letter-spacing: 3px;
}

.search-card-content {
    padding: 20px;
}

.search-card-content span {
    color: #a47d4d;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.search-card-content h3 {
    font-family: 'Playfair Display', serif;
    font-size: 21px;
    margin: 10px 0;
}

.search-card-content p,
.search-empty {
    color: #777;
    font-size: 14px;
}

.search-pagination {
    margin-top: 30px;
}

.search-no-results {
    text-align: center;
    padding: 50px 15px;
    background: #f8f5f1;
    margin-bottom: 40px;
}

.search-no-results h2 {
    font-family: 'Playfair Display', serif;
}

@media(max-width: 991px) {
    .elora-header-search {
        margin-left: auto;
        margin-right: 15px;
    }
}

@media(max-width: 576px) {
    .elora-search-page {
        padding: 40px 0 60px;
    }

    .search-heading h1 {
        font-size: 32px;
    }

    .search-section-heading h2 {
        font-size: 23px;
    }

    .search-result-card img,
    .search-image-placeholder {
        height: 240px;
    }
}
</style>
@endpush
