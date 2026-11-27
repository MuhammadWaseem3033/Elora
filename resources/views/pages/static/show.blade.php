@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title . ' | ÉLORA')

@section('meta_description', $page->meta_description ?: (Str::limit(strip_tags($page->content ?? ''), 160) ?:
    $page->title . ' | ÉLORA Fashion & Style'))

@section('canonical_url', route('page.show', $page->slug))

@section('meta_image', asset($page->featured_image && is_file(public_path($page->featured_image)) ?
    $page->featured_image : 'images/seo/elora-og.jpg'))
@section('og_type', 'website')

@section('content')

    <section class="page-hero">
        <span class="eyebrow">ÉLORA / INFORMATION</span>

        <h1>{{ $page->title }}</h1>
    </section>

    <section class="section container">

        @if ($page->featured_image)
            <div class="mb-5">
                <img src="{{ asset($page->featured_image) }}" alt="{{ $page->title }}"
                    style="width:100%; max-height:500px; object-fit:cover;" fetchpriority="high" decoding="async">
            </div>
        @endif

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
