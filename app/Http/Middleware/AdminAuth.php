<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Closure;
use Auth;
class AdminAuth
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) { 
             return redirect(RouteServiceProvider::ADMIN_LOGIN);
        }

        if (Auth::check())
        {
            if (Auth::user()->user_type != 1) {
                 return redirect('/admin/logout');
            }
        }  

        return $next($request);
    }
}
