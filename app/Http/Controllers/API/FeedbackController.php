<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function feedback(Request $request) {
        $feedback = [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'content' => $request->content,
        ];

        Feedback::create($feedback);
        return response()->json([
            'message' => 'Feedback is sent successfully.'
        ],200);

    }
}
