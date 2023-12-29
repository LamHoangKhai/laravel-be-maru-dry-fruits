<?php

namespace App\Http\Controllers\API;

use App\Events\UserFeedback;
use App\Events\UserOrder;
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
            'timestamps' => now()
        ];
        
        $new_feedback = Feedback::create($feedback);
        event(new UserFeedback($new_feedback));

        return response()->json([
            'message' => 'Feedback is sent successfully.'
        ],200);

    }
}
