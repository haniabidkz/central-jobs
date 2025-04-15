<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Company
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //return $next($request);
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == 2) {
            return redirect()->route('candidate');
        }
        if (Auth::user()->role == 3) {
            return redirect()->route('company');
        }
    }
}
