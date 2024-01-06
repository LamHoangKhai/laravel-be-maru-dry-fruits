<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newFeedback = Feedback::where('created_at', '>=', Carbon::now()->subDay())->count();
        $newOrder = Order::where("status", 1)->count();

        return
            view(
                "admin.modules.dashboard.index",
                [
                    "newFeedback" => $newFeedback,
                    "newOrder" => $newOrder,
                ]
            );
    }
}
