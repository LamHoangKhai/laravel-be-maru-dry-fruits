<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BannerAndSlide;
use Illuminate\Http\Request;

class BannerAndSlideController extends Controller
{
    public function banner_and_slide(Request $request) {
        $position = $request->position;
        $banner_and_slide = BannerAndSlide::where('position', $position)->get();
        return response()->json([
            'data' => $banner_and_slide
        ],200);
    }
}
