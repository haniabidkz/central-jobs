<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Admin accounts authenticate on the dedicated "admin" guard. Sessions created
 * before that change still carry the admin user on the public "web" guard, which
 * makes the public site treat the visitor as an admin and bounce them to the
 * admin panel. Evict such a login from the public guard so the public site only
 * ever sees candidates and companies.
 */
class ClearLegacyAdminWebLogin
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
        $web = Auth::guard('web');

        if ($web->check() && $web->user()->user_type == 1) {
            $web->logout();
        }

        return $next($request);
    }
}
