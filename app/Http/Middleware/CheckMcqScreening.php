<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Auth;

class CheckMcqScreening
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
        /* if ((Auth::user()) && (Auth::user()->user_type == 2) && (Auth::user()->is_mcq_complete == 0)) {
            return redirect('candidate/screening-mcq/');
        } */
        if (!Auth::guard($guards)->check()) {
            $segment = request()->segment(2); 
            if($segment == 'message'){
                $request->session()->flash('error-msg', __('messages.PLEASE_LOGIN_TO_SEE_YOUR_MESSAGE') );
            }
            return redirect(RouteServiceProvider::USER_LOGIN);
        }
        return $next($request);
    }
}
