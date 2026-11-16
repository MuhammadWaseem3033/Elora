<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\StaticPage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CategroyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(
            ['partials.header', 'partials.footer'],
            function ($view) {

                // Active Categories
                $headerCategories = Category::query()
                    ->select('id', 'name', 'slug')
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();

                // Published Static Pages
                $footerPages = StaticPage::query()
                    ->select('id', 'title', 'slug', 'sort_order')
                    ->where('status', 'published')
                    ->orderBy('sort_order')
                    ->get();

                // dd($footerPages);

                $headerPage = $footerPages->firstWhere('slug', 'about');

                $footerBrandPages = $footerPages->whereIn('slug', [
                    'about',
                    'advertising',
                ]);

                $footerInfoPages = $footerPages->whereNotIn('slug', [
                    'about',
                    'advertising',
                ]);

                $view->with(compact(
                    'headerCategories',
                    'headerPage',
                    'footerBrandPages',
                    'footerInfoPages'
                ));
            }
        );
    }
}
