<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Design;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $search = trim((string) $request->query('q', ''));

        $designs = collect();
        $articles = collect();

        if (mb_strlen($search) >= 2) {

            // Search Fashion Designs
            $designs = Design::query()
                ->where('status', 'published')
                ->where(function ($query) {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                })
                ->whereHas('category', function ($query) {
                    $query->where('is_active', true);
                })
                ->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('designer', 'like', "%{$search}%")
                        ->orWhere('collection_name', 'like', "%{$search}%");
                })
                ->with('category:id,name,slug')
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->paginate(6, ['*'], 'designs_page')
                ->withQueryString();

            // Search Journal Articles
            $articles = Article::query()
                ->where('status', 'published')
                ->where(function ($query) {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                })
                ->whereHas('blogCategory', function ($query) {
                    $query->where('is_active', true);
                })
                ->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                })
                ->with('blogCategory:id,name,slug')
                ->orderByDesc('published_at')
                ->paginate(6, ['*'], 'articles_page')
                ->withQueryString();
        }

        return view('pages.search.index', compact(
            'search',
            'designs',
            'articles'
        ));
    }
}
