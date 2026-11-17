<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    {{-- Homepage --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Categories --}}
    @foreach ($categories as $category)
        <url>
            <loc>{{ route('category.show', $category->slug) }}</loc>
            <lastmod>{{ $category->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    {{-- Fashion Designs --}}
    @foreach ($designs as $design)
        <url>
            <loc>{{ route('design.show', $design->slug) }}</loc>
            <lastmod>{{ $design->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>

            @if ($design->featured_image)
                <image:image>
                    <image:loc>{{ asset($design->featured_image) }}</image:loc>
                    <image:title>{{ $design->title }}</image:title>
                </image:image>
            @endif
        </url>
    @endforeach

    {{-- Journal Articles --}}
    @foreach ($articles as $article)
        <url>
            <loc>{{ route('journal.show', $article->slug) }}</loc>
            <lastmod>{{ $article->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>

            @if ($article->featured_image)
                <image:image>
                    <image:loc>{{ asset($article->featured_image) }}</image:loc>
                    <image:title>{{ $article->title }}</image:title>
                </image:image>
            @endif
        </url>
    @endforeach

    {{-- Static Pages --}}
    @foreach ($pages as $page)
        <url>
            <loc>{{ route('page.show', $page->slug) }}</loc>
            <lastmod>{{ $page->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach

    {{-- Journal Homepage --}}
    <url>
        <loc>{{ route('journal.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>

</urlset>
