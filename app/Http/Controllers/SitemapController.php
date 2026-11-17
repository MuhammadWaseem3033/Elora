<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Design;
use App\Models\StaticPage;

class SitemapController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $designs = Design::query()
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->with('category:id,name,slug')
            ->orderBy('updated_at', 'desc')
            ->get();

        $articles = Article::query()
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->whereHas('blogCategory', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        $pages = StaticPage::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->get();

        return response()
            ->view('pages.sitemap.index', compact(
                'categories',
                'designs',
                'articles',
                'pages'
            ))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots()
    {
        $content = "User-agent: *\n"
            . "Allow: /\n"
            . "Disallow: /admin\n"
            . "Disallow: /search\n"
            . "\n"
            . "Sitemap: " . rtrim(config('app.url'), '/') . "/sitemap.xml\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}
