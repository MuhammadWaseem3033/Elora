<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\BlogCategory;

class JournalController extends Controller
{
    public function show(string $slug)
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->with([
                'blogCategory:id,name,slug',
                'designs',
            ])
            ->firstOrFail();
        $relatedArticles = Article::query()
            ->where('blog_category_id', $article->blog_category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.journal.show', compact('article', 'relatedArticles'));
    }

    // All journal articles
    public function index()
    {
        $blogCategories = BlogCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $selectedCategory = null;

        $articles = Article::query()
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->whereHas('blogCategory', function ($query) {
                $query->where('is_active', true);
            })
            ->with('blogCategory:id,name,slug')
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('pages.journal.index', compact(
            'blogCategories',
            'selectedCategory',
            'articles'
        ));
    }

    // Articles by category
    public function category(string $slug)
    {
        $blogCategories = BlogCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $selectedCategory = BlogCategory::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $articles = Article::query()
            ->where('blog_category_id', $selectedCategory->id)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->with('blogCategory:id,name,slug')
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('pages.journal.index', compact(
            'blogCategories',
            'selectedCategory',
            'articles'
        ));
    }
}
