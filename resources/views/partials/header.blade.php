{{-- <div class="topline">The art of personal style · Independent fashion journal</div>

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
</header> --}}

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

            @if ($headerPage)
                <a href="{{ route('page.show', $headerPage->slug) }}">
                    {{ $headerPage->title }}
                </a>
            @endif
        </nav>

        <form action="{{ route('search.index') }}" method="GET" class="elora-header-search">

            <input type="search" name="q" placeholder="Search..." value="{{ request('q') }}"
                aria-label="Search fashion designs and articles" required minlength="2" maxlength="100">

            <button type="submit" aria-label="Search">
                <span>⌕</span>
            </button>
        </form>

        <button class="menu-btn" aria-label="Open menu">
            ☰
        </button>

    </div>
</header>
