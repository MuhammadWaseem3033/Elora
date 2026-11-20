<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use App\Models\Design;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $homeData = Cache::remember('elora_homepage_data', 300, function () {
            $categories = Category::query()
                ->select('id', 'name', 'slug', 'image', 'description')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->limit(4)
                ->get();

            $featuredDesigns = Design::query()
                ->select(
                    'id',
                    'category_id',
                    'title',
                    'slug',
                    'short_description',
                    'featured_image',
                    'designer',
                    'collection_name'
                )
                ->where('status', 'published')
                ->where('is_featured', true)
                ->where(function ($query) {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                })
                ->whereHas('category', function ($query) {
                    $query->where('is_active', true);
                })
                ->with([
                    'images:id,design_id,image,alt_text,sort_order'
                ])
                ->orderBy('sort_order')
                ->limit(4)
                ->get();

            $articles = Article::query()
                ->select(
                    'id',
                    'blog_category_id',
                    'title',
                    'slug',
                    'excerpt',
                    'featured_image',
                    'author',
                    'published_at'
                )
                ->where('status', 'published')
                ->whereHas('blogCategory', function ($query) {
                    $query->where('is_active', true);
                })
                ->where(function ($query) {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                })
                ->with('blogCategory:id,name,slug')
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->limit(3)
                ->get();

            return compact('categories', 'featuredDesigns', 'articles');
        });

        return view('pages.home', $homeData);
    }
}
