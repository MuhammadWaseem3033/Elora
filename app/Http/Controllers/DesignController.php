<?php

namespace App\Http\Controllers;

use App\Models\Design;

class DesignController extends Controller
{
    public function show(string $slug)
    {
        $design = Design::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->with([
                'category:id,name,slug',
                'images',
            ])
            ->firstOrFail();

        // For Design Views Count Uniqe  
        $viewedDesigns = session()->get('viewed_designs', []);

        if (!in_array($design->id, $viewedDesigns)) {
            $design->increment('views');

            $viewedDesigns[] = $design->id;

            session()->put('viewed_designs', $viewedDesigns);
        }

        // Related Designs
        $relatedDesigns = Design::query()
            ->where('category_id', $design->category_id)
            ->where('id', '!=', $design->id)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        // Previous and Next Designs
        $categoryDesigns = Design::query()
            ->where('category_id', $design->category_id)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id');

        $currentIndex = $categoryDesigns->search($design->id);

        $previousDesign = $currentIndex !== false && $currentIndex > 0
            ? Design::find($categoryDesigns[$currentIndex - 1])
            : null;

        $nextDesign = $currentIndex !== false
            && $currentIndex < $categoryDesigns->count() - 1
            ? Design::find($categoryDesigns[$currentIndex + 1])
            : null;

        return view('pages.designs.show', compact(
            'design',
            'relatedDesigns',
            'previousDesign',
            'nextDesign'
        ));
    }
}
