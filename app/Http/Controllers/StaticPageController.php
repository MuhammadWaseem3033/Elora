<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;

class StaticPageController extends Controller
{
    public function show(string $slug)
    {
        $page = StaticPage::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('pages.static.show', compact('page'));
    }
}
