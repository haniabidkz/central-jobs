<?php
namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectAdminAuthenticated
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
        if (Auth::guard($guard)->check()) {   
             //if user logged in & try to login to admin then redirect to logged dashboard            
            if(Auth::user()->user_type == 2){ // candidate
                return redirect('/candidate/dashboard');
            }
            if(Auth::user()->user_type == 3){ // company
                return redirect('/company/dashboard');
            }
             return redirect()->route(RouteServiceProvider::ADMIN_DASHBOARD);
        
        }

        return $next($request);
    }
}
