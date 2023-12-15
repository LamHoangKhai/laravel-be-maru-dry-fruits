<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BannerAndSlide;
use Illuminate\Http\Request;

class BannerAndSlideController extends Controller
{
    public function banner_and_slide() {
        $banner_and_slide = BannerAndSlide::all();
        return response()->json([
            'banner_and_slide' => $banner_and_slide
        ],200);
    }
}
