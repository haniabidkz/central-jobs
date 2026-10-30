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
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::ADMIN_LOGIN);
        }

        if (Auth::guard($guard)->user()->user_type != 1) {
            Auth::guard($guard)->logout();
            return redirect(RouteServiceProvider::ADMIN_LOGIN);
        }

        // Auth::user() / auth()->id() now resolve to the admin for the rest of this request,
        // so shared services keep working without a candidate/company session getting in the way
        Auth::shouldUse($guard);

        return $next($request);
    }
}
