<div class="topline">The art of personal style · Independent fashion journal</div>

<header class="header">
    <div class="container nav-wrap">

        <a class="brand" href="{{ route('home') }}">
            ÉLORA
            <small>STYLE JOURNAL</small>
        </a>

        <nav class="nav">
            <a href="{{ route('home') }}">Home</a>
            @foreach ($headerCategories as $category)
                <a href="{{ route('category.show', $category->slug) }}">
                    {{ $category->name }}
                </a>
            @endforeach

            <a href="{{ route('journal.index') }}">Journal</a>
            {{-- <a href="{{ route('page.show', 'about') }}">About</a>
            <a href="{{ route('page.show', 'about') }}">About</a>
            <a href="{{ route('page.show', 'about') }}">About</a>
            <a href="{{ route('page.show', 'about') }}">About</a>
            <a href="{{ route('page.show', 'about') }}">About</a> --}}
            {{-- @dd($headerPage) --}}
            {{-- @foreach ($headerPage as $page)
                <a href="{{ route('page.show', 'about') }}">{{ $page }}</a>
            @endforeach --}}
            @if ($headerPage)
                <a href="{{ route('page.show', $headerPage->slug) }}">
                    {{ $headerPage->title }}
                </a>
            @endif

        </nav>

        <button class="menu-btn" aria-label="Open menu">
            ☰
        </button>

    </div>
</header>
