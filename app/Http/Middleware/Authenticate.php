<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Providers\RouteServiceProvider;
use Auth;
use Closure;
use App;
use Cookie;
use Session;

class Authenticate extends Middleware
{
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
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
            if (Auth::user()->user_type != 2) {
                 return redirect('/logout');
            }
        }
        
        if (!Auth::guard($guards)->check()) {
            $segment = request()->segment(2); 
            if(Cookie::has('locale')){
                App::setLocale(Cookie::get('locale'));
            }
            if($segment == 'dashboard'){
                $request->session()->flash('error-msg', __('messages.PLEASE_LOGIN_TO_SEE_YOUR_DASHBOARD') );
            }
            if($segment == 'search-profile' || $segment == 'my-network'){
                $request->session()->flash('error-msg', __('messages.PLEASE_LOGIN_TO_SEE_YOUR_NETWORK') );
            }
            if($segment == 'apply-job' || $segment == 'track-job'){
                $request->session()->flash('error-msg', __('messages.PLEASE_LOGIN_TO_APPLY') );
            }
            return redirect(RouteServiceProvider::USER_LOGIN);
        }
        return $next($request);
    } 
    
}
