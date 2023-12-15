<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutSeviceController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            // handle logout
            Auth::guard("web")->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('login');
        } catch (Exception) {
            redirect()->route('login');
        }
    }
}
