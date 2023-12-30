<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // handle authentication
        if (Auth::guard("web")->check() && Auth::guard("web")->user()->level == 1 && Auth::guard("web")->user()->status == 1) {
            return $next($request);
        }
        return redirect()->route("login");
    }
}
