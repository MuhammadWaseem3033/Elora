<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;

class AdvertisementController extends Controller
{

    public function click(Advertisement $advertisement)
    {
        if (!$advertisement->is_active ||
            ($advertisement->start_date && $advertisement->start_date->isFuture()) ||
            ($advertisement->end_date && $advertisement->end_date->isPast())
        ) {
            return response()->noContent();
        }

        $clickedAds = session()->get('clicked_ads', []);

        if (!in_array($advertisement->id, $clickedAds)) {
            $advertisement->increment('clicks');

            $clickedAds[] = $advertisement->id;

            session()->put('clicked_ads', $clickedAds);
        }

        return response()->noContent();
    }
}
