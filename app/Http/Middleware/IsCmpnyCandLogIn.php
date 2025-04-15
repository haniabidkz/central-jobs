<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class IsCmpnyCandLogIn
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
        if (!Auth::check()) {
            $segment = request()->segment(2); 
            if($segment == 'message'){
                $request->session()->flash('error-msg', __('messages.PLEASE_LOGIN_TO_SEE_YOUR_MESSAGE') );
            }
            return redirect()->route('login');
        }
        if (Auth::user()->status == 0) {
            $email = base64_encode(Auth::user()->email);
            //check is user blocked
            return redirect('/blocked-by-admin/'.$email);
        }
        
        if (Auth::user()->user_type == 1) {
            return redirect()->route('/logout');
        }
        
        return $next($request);
    }
}

