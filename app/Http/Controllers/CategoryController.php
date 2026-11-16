<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with(['designs' => function ($query) {
                $query->where('status', 'published')
                    ->orderBy('sort_order')
                    ->latest();
            }])
            ->firstOrFail();

        return view('pages.categories.show', compact('category'));
    }
}
