<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function viewLogin()
    {

        if (Auth::guard("web")->check()) {
            return redirect()->route("admin.user.index");
        }
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $user = User::where("email", $request->email)->first();

        if (!$user || $user->level != 1) {
            return redirect("/");
        }

        $credentials = [
            "email" => $request->email,
            "password" => $request->password,
            "status" => 1,
        ];

        if (Auth::guard("web")->attempt($credentials)) {

            return redirect()->route('admin.user.index')->with('success', "Login success");
        }

        return back();
    }
}


