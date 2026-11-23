{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ÉLORA | Fashion & Style')</title>

    <meta name="description" content="@yield('meta_description', 'Explore the world of women’s fashion, elegant designs, fashion shows and style inspiration at ÉLORA.')">

    <meta name="robots" content="index, follow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>

<body>

    @includeIf('partials.header')

    <main id="page-content">
        @yield('content')
    </main>

    @includeIf('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/main.js') }}" defer></script>

    @stack('scripts')

</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $seoTitle = trim($__env->yieldContent('title', 'ÉLORA | Fashion & Style'));
        $seoDescription = trim(
            $__env->yieldContent(
                'meta_description',
                'Explore the world of women’s fashion, elegant designs, fashion shows and style inspiration at ÉLORA.',
            ),
        );
        $seoCanonical = trim($__env->yieldContent('canonical_url', url()->current()));
        $seoImage = trim($__env->yieldContent('meta_image', ''));
        $seoRobots = trim($__env->yieldContent('robots', 'index, follow'));
        $seoType = trim($__env->yieldContent('og_type', 'website'));
    @endphp

    {{-- Basic SEO --}}
    <title>{{ $seoTitle }}</title>

    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="{{ $seoRobots }}">
    <link rel="canonical" href="{{ $seoCanonical }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:site_name" content="ÉLORA">
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:locale" content="en_US">

    @if ($seoImage)
        <meta property="og:image" content="{{ $seoImage }}">
    @endif

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="{{ $seoImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">

    @if ($seoImage)
        <meta name="twitter:image" content="{{ $seoImage }}">
    @endif

    {{-- Website Schema --}}

    @php
        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'ÉLORA',
            'description' => $seoDescription,
            'url' => config('app.url'),
            'inLanguage' => 'en',
        ];

        $websiteSchemaJson = json_encode($websiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    @endphp

    <script type="application/ld+json">
        {!! $websiteSchemaJson !!}
    </script>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    @stack('styles')
</head>

<body>

    @includeIf('partials.header')

    <main id="page-content">
        @yield('content')
    </main>

    @includeIf('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/main.js') }}" defer></script>

    @stack('scripts')

</body>

</html>
