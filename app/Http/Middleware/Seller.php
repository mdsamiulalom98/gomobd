<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Seller
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::guard('seller')->user()) {
            return $next($request);
        }
        return redirect()->route('seller.login');
    }
}
