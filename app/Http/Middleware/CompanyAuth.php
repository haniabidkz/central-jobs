<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Auth;
use Closure;

class CompanyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check())
        {
            if (Auth::user()->status == 0) {
                $email = base64_encode(Auth::user()->email);
                //check is user blocked
                return redirect('/blocked-by-admin/'.$email);
            }
            if (Auth::user()->status == 2) {
                $email = base64_encode(Auth::user()->email);
                //check is user blocked
                return redirect('/deactivated-user/'.$email);
            }

            if (Auth::user()->user_type != 3) {
                 return redirect('/logout');
            }
        }           
        
        if (!Auth::guard($guards)->check()) {
            return redirect(RouteServiceProvider::USER_LOGIN);
        }
        return $next($request);
    }
}
