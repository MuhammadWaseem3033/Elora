@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title . ' | ÉLORA')

@section('meta_description', $page->meta_description ?: Str::limit(strip_tags($page->content), 160))

@section('content')

    <section class="page-hero">
        <span class="eyebrow">ÉLORA / INFORMATION</span>

        <h1>{{ $page->title }}</h1>
    </section>

    <section class="section container">

        @if ($page->featured_image)
            <div class="mb-5">
                <img src="{{ asset($page->featured_image) }}" alt="{{ $page->title }}"
                    style="width:100%; max-height:500px; object-fit:cover;" fetchpriority="high" decoding="async"
                    loading="lazy"
                    >
                </ @endif

                <div class="static-page-content">
                    {!! $page->content !!}
                </div>

                <div class="mt-5">
                    <a href="{{ route('home') }}" class="text-link">
                        ← Back to Home
                    </a>
                </div>

    </section>

@endsection
