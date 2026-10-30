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
    public function handle($request, Closure $next, $guard = 'admin')
    {
        // admin sessions live on their own guard, so a candidate/company login
        // on the public site no longer blocks or breaks the admin login page
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
        }

        return $next($request);
    }
}
