<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;

class AdvertisementController extends Controller
{
    public function click(Advertisement $advertisement)
    {
        if (!$advertisement->is_active) {
            return response()->noContent();
        }

        $advertisement->increment('clicks');

        return response()->noContent();
    }
}
